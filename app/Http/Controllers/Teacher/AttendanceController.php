<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\ScopesTeacherAssignments;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Classes;
use App\Models\Section;
use App\Models\StudentProfile;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    use ScopesTeacherAssignments;

    private function dayOfWeekFromDate(string $date): string
    {
        return date('l', strtotime($date));
    }

    public function create(): View
    {
        $pairs = $this->allowedPairs();

        $classes = Classes::whereIn('id', $pairs->pluck('class_id')->unique())
            ->orderBy('numeric_value')
            ->get(['id', 'name']);

        // Only the sessions this teacher personally recorded (not other staff).
        $sessions = AttendanceSession::with(['schoolClass', 'section', 'recordedBy', 'attendances'])
            ->where('recorded_by', auth()->id())
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get();

        return view('app.teacher.attendance.take', compact('classes', 'sessions'));
    }

    /**
     * Read-only detail (student roster) of a single session this teacher recorded.
     */
    public function show(int $session): View
    {
        $attendanceSession = AttendanceSession::with([
            'attendances.user', 'recordedBy', 'schoolClass', 'section',
            'timeTable.class', 'timeTable.section',
        ])->where('recorded_by', auth()->id())->findOrFail($session);

        $classId   = (int) ($attendanceSession->class_id ?? $attendanceSession->timeTable?->class_id);
        $sectionId = (int) ($attendanceSession->section_id ?? $attendanceSession->timeTable?->section_id);

        $existing = $attendanceSession->attendances->keyBy('user_id');

        $students = StudentProfile::with('student')
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->orderBy('admission_no')
            ->get()
            ->map(function (StudentProfile $profile) use ($existing) {
                $record = $existing->get($profile->student_id);
                $profile->attendance_status  = $record?->status;
                $profile->attendance_remarks = $record?->remarks;

                return $profile;
            });

        $total   = $attendanceSession->attendances->count();
        $present = $attendanceSession->attendances->where('status', 'present')->count();
        $absent  = $attendanceSession->attendances->where('status', 'absent')->count();
        $late    = $attendanceSession->attendances->where('status', 'late')->count();

        $stats = [
            'total'      => $total,
            'present'    => $present,
            'absent'     => $absent,
            'late'       => $late,
            'percentage' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
        ];

        return view('app.teacher.attendance.show', [
            'session'  => $attendanceSession,
            'students' => $students,
            'stats'    => $stats,
        ]);
    }

    /**
     * Sections of a class that the teacher is allowed to take attendance for.
     */
    public function getSections(Request $request)
    {
        $request->validate(['class_id' => 'required|integer']);

        $classId      = (int) $request->input('class_id');
        $allowedIds   = $this->allowedPairs()
            ->where('class_id', $classId)
            ->pluck('section_id')
            ->unique();

        $sections = Section::whereIn('id', $allowedIds)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['sections' => $sections]);
    }

    public function checkClasses(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'class_id'   => 'required|integer',
            'section_id' => 'required|integer',
        ]);

        $classId   = (int) $request->input('class_id');
        $sectionId = (int) $request->input('section_id');

        if (! $this->allows($classId, $sectionId)) {
            return response()->json([
                'has_classes'  => false,
                'has_timetable'=> false,
                'has_students' => false,
                'date'         => $request->input('date'),
            ]);
        }

        $branchId  = $this->branchId();
        $dayOfWeek = $this->dayOfWeekFromDate($request->input('date'));

        $hasTimetable = TimeTable::where('day_of_week', $dayOfWeek)
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->exists();

        $hasStudents = StudentProfile::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->exists();

        return response()->json([
            'has_classes'   => $hasTimetable || $hasStudents,
            'has_timetable' => $hasTimetable,
            'has_students'  => $hasStudents,
            'date'          => $request->input('date'),
        ]);
    }

    public function getStudents(Request $request)
    {
        $request->validate([
            'class_id'   => 'required|integer',
            'section_id' => 'required|integer',
            'date'       => 'required|date',
        ]);

        $classId   = (int) $request->input('class_id');
        $sectionId = (int) $request->input('section_id');
        $date      = $request->input('date');

        abort_unless($this->allows($classId, $sectionId), 403, 'You are not assigned to this class/section.');

        $class   = Classes::findOrFail($classId);
        $section = Section::findOrFail($sectionId);

        $students = StudentProfile::with(['student'])
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->orderBy('admission_no')
            ->get()
            ->map(function (StudentProfile $profile) {
                $profilePic = $profile->student?->profile_pic;
                $profile->photo_url = $profilePic
                    ? asset('assets/'.$profilePic)
                    : asset('backend/img/profile/1.jpg');

                return $profile;
            });

        // Resolve any existing session for this class/section/date (full day).
        $dayOfWeek = $this->dayOfWeekFromDate($date);
        $branchId  = $this->branchId();

        $timetable = TimeTable::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->where('day_of_week', $dayOfWeek)
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->first();

        $session = $timetable
            ? AttendanceSession::where('time_table_id', $timetable->id)->whereDate('date', $date)->first()
            : AttendanceSession::whereNull('time_table_id')
                ->where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->whereDate('date', $date)
                ->first();

        $existingAttendance = $session
            ? $session->attendances()->select('user_id', 'status', 'remarks')->get()->keyBy('user_id')->toArray()
            : [];

        return response()->json([
            'class'              => $class,
            'section'            => $section,
            'students'           => $students,
            'existingAttendance' => $existingAttendance,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id'   => 'required|integer',
            'section_id' => 'required|integer',
            'date'       => 'required|date',
            'status'     => 'required|in:draft,submitted',
            'attendance' => 'required|array',
        ]);

        $classId   = (int) $request->input('class_id');
        $sectionId = (int) $request->input('section_id');

        abort_unless($this->allows($classId, $sectionId), 403, 'You are not assigned to this class/section.');

        $branchId = $this->branchId();

        if (! $branchId) {
            return response()->json([
                'success' => false,
                'message' => 'Branch is not configured. Please contact the administrator.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            $date           = $request->input('date');
            $sessionStatus  = $request->input('status') === 'submitted' ? 'submitted' : 'draft';
            $attendanceData = $request->input('attendance');

            $dayOfWeek = $this->dayOfWeekFromDate($date);
            $timetable = TimeTable::where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->where('day_of_week', $dayOfWeek)
                ->where('branch_id', $branchId)
                ->first();

            if ($timetable) {
                $session = AttendanceSession::updateOrCreate(
                    ['branch_id' => $branchId, 'time_table_id' => $timetable->id, 'date' => $date],
                    ['recorded_by' => auth()->id(), 'class_id' => $classId, 'section_id' => $sectionId, 'notes' => 'Full day', 'status' => $sessionStatus]
                );
            } else {
                $session = AttendanceSession::where('branch_id', $branchId)
                    ->whereNull('time_table_id')
                    ->where('class_id', $classId)
                    ->where('section_id', $sectionId)
                    ->whereDate('date', $date)
                    ->first();

                if ($session) {
                    $session->update(['recorded_by' => auth()->id(), 'notes' => 'Full day', 'status' => $sessionStatus]);
                } else {
                    $session = AttendanceSession::create([
                        'branch_id'     => $branchId,
                        'time_table_id' => null,
                        'class_id'      => $classId,
                        'section_id'    => $sectionId,
                        'date'          => $date,
                        'recorded_by'   => auth()->id(),
                        'notes'         => 'Full day',
                        'status'        => $sessionStatus,
                    ]);
                }
            }

            foreach ($attendanceData as $studentAttendance) {
                if (empty($studentAttendance['status'])) {
                    continue;
                }

                Attendance::updateOrCreate(
                    [
                        'session_id' => $session->id,
                        'user_id'    => $studentAttendance['student_id'],
                    ],
                    [
                        'branch_id' => $branchId,
                        'status'    => $studentAttendance['status'],
                        'remarks'   => $studentAttendance['remarks'] ?? null,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Attendance saved successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save attendance: '.$e->getMessage(),
            ], 500);
        }
    }
}
