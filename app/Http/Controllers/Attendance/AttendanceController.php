<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TimeTable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StudentProfile;
use App\Models\AttendanceSession;
use App\Models\Attendance;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AttendanceController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');
        $schoolId = auth()->user()->school_id ?? School::first()->id;

        // Get today's attendance sessions
        $todaySessions = AttendanceSession::where('school_id', $schoolId)
            ->whereDate('date', $today)
            ->with(['attendances' => function ($query) {
                $query->with('user');
            }])
            ->get();

        // Calculate statistics
        $stats = [
            'today' => [
                'total_students' => 0,
                'present' => 0,
                'absent' => 0,
                'late' => 0,
                'percentage' => 0,
            ],
            'monthly' => [
                'total_students' => 0,
                'present' => 0,
                'percentage' => 0,
                'change' => 0,
            ],
            'teachers' => [
                'total' => 0,
                'present' => 0,
                'percentage' => 0,
                'absent' => 0,
            ],
            'classes' => []
        ];

        // Process today's attendance
        foreach ($todaySessions as $session) {
            foreach ($session->attendances as $attendance) {
                if ($attendance->user->hasRole('student')) {
                    $stats['today']['total_students']++;
                    if ($attendance->status === 'present') {
                        $stats['today']['present']++;
                    } elseif ($attendance->status === 'absent') {
                        $stats['today']['absent']++;
                    } elseif ($attendance->status === 'late') {
                        $stats['today']['late']++;
                    }
                } elseif ($attendance->user->hasRole('teacher')) {
                    $stats['teachers']['total']++;
                    if ($attendance->status === 'present') {
                        $stats['teachers']['present']++;
                    }
                }
            }
        }

        // Calculate percentages
        if ($stats['today']['total_students'] > 0) {
            $stats['today']['percentage'] = round(($stats['today']['present'] / $stats['today']['total_students']) * 100, 1);
        }

        if ($stats['teachers']['total'] > 0) {
            $stats['teachers']['percentage'] = round(($stats['teachers']['present'] / $stats['teachers']['total']) * 100, 1);
            $stats['teachers']['absent'] = $stats['teachers']['total'] - $stats['teachers']['present'];
        }

        // In your controller, modify the stats calculation:
        $stats['today']['absent_percentage'] = $stats['today']['total_students'] > 0
            ? round(($stats['today']['absent'] / $stats['today']['total_students']) * 100)
            : 0;

        // Get monthly data (last 30 days)
        $monthStart = now()->subDays(30)->format('Y-m-d');
        $monthlyAttendances = Attendance::whereHas('session', function ($query) use ($schoolId, $monthStart) {
            $query->where('school_id', $schoolId)
                ->whereDate('date', '>=', $monthStart);
        })->whereHas('user', function ($query) {
            $query->role('student');
        })->get();

        if ($monthlyAttendances->count() > 0) {
            $stats['monthly']['present'] = $monthlyAttendances->where('status', 'present')->count();
            $stats['monthly']['total_students'] = $monthlyAttendances->count();
            $stats['monthly']['percentage'] = round(($stats['monthly']['present'] / $stats['monthly']['total_students']) * 100, 1);
        }

        // Get classes with lowest attendance
        $lowestClasses = AttendanceSession::where('school_id', $schoolId)
            ->whereDate('date', $today)
            ->with(['attendances', 'timeTable.class', 'timeTable.section'])
            ->get()
            ->map(function ($session) {
                $total = $session->attendances->count();
                $present = $session->attendances->where('status', 'present')->count();
                $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

                return [
                    'class' => $session->timeTable->class->name ?? 'N/A',
                    'section' => $session->timeTable->section->name ?? 'N/A',
                    'present' => $present,
                    'absent' => $total - $present,
                    'percentage' => $percentage
                ];
            })
            ->sortBy('percentage')
            ->take(3)
            ->values()
            ->all();

        // Recent attendance records
        $recentRecords = AttendanceSession::where('school_id', $schoolId)
            ->with(['timeTable.class', 'timeTable.section', 'attendances'])
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($session) {
                $total = $session->attendances->count();
                $present = $session->attendances->where('status', 'present')->count();
                $absent = $session->attendances->where('status', 'absent')->count();
                $late = $session->attendances->where('status', 'late')->count();
                $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

                return [
                    'date' => $session->date,
                    'class' => $session->timeTable->class->name ?? 'N/A',
                    'section' => $session->timeTable->section->name ?? 'N/A',
                    'present' => $present,
                    'absent' => $absent,
                    'late' => $late,
                    'percentage' => $percentage,

                ];
            });

        // Calendar events
        $calendarEvents = AttendanceSession::where('school_id', $schoolId)
            ->whereDate('date', '>=', now()->subMonth())
            ->with(['timeTable.class', 'timeTable.section', 'attendances'])
            ->get()
            ->map(function ($session) {
                $total = $session->attendances->count();
                $present = $session->attendances->where('status', 'present')->count();
                $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

                return [
                    'title' => ($session->timeTable->class->name ?? 'Class') . ' - ' . $percentage . '%',
                    'start' => $session->date,
                    'className' => $percentage >= 90 ? 'bg-success' : ($percentage >= 75 ? 'bg-warning' : 'bg-danger')
                ];
            });

        return view('app.attendance.index', [
            'stats' => $stats,
            'lowestClasses' => $lowestClasses,
            'recentRecords' => $recentRecords,
            'calendarEvents' => $calendarEvents,
            'attendanceTrends' => $this->getAttendanceTrendData($schoolId)

        ]);
    }




    protected function getAttendanceTrendData($schoolId, $days = 7)
    {
        $trendData = [
            'days' => [],
            'present' => [],
            'absent' => [],
            'late' => []
        ];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $trendData['days'][] = $date->format('D');

            $counts = Attendance::whereHas('session', function ($q) use ($date, $schoolId) {
                $q->whereDate('date', $date->format('Y-m-d'))
                    ->where('school_id', $schoolId);
            })
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');

            $trendData['present'][] = $counts['present'] ?? 0;
            $trendData['absent'][] = $counts['absent'] ?? 0;
            $trendData['late'][] = $counts['late'] ?? 0;
        }

        return $trendData;
    }


    public function getAttendanceTrends(Request $request)
    {
        $period = $request->input('period', 'daily');
        $schoolId = auth()->user()->school_id ?? School::first()->id;

        $days = [];
        $present = [];
        $absent = [];
        $late = [];

        switch ($period) {
            case 'weekly':
                $range = 6; // Last 7 days
                $format = 'D'; // Day name
                break;
            case 'monthly':
                $range = 29; // Last 30 days
                $format = 'M d'; // Month day
                break;
            default: // daily
                $range = 6; // Last 7 days
                $format = 'D'; // Day name
        }

        for ($i = $range; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format($format);

            $counts = Attendance::whereHas('session', function ($q) use ($date, $schoolId) {
                $q->whereDate('date', $date->format('Y-m-d'))
                    ->where('school_id', $schoolId);
            })
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');

            $present[] = $counts['present'] ?? 0;
            $absent[] = $counts['absent'] ?? 0;
            $late[] = $counts['late'] ?? 0;
        }

        return response()->json([
            'days' => $days,
            'present' => $present,
            'absent' => $absent,
            'late' => $late
        ]);
    }


    public function create()
    {
        // if subject wise attendance the update data for system_setting 
        $classes = Classes::orderBy('numeric_value')->get();
        return view('app.attendance.take_attendance', compact('classes'));
    }

    /**
     * Get sections for a class (AJAX)
     */
    public function getSections(Request $request)
    {
        $classId = $request->input('class_id');

        $sections = Section::where('class_id', $classId)
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('name')
            ->get();

        return response()->json([
            'sections' => $sections
        ]);
    }

    /**
     * Get subjects for a class (AJAX)
     */
    public function getSubjects(Request $request)
    {
        $classId = $request->input('class_id');

        $subjects = Subject::where('class_id', $classId)
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('name')
            ->get();

        return response()->json([
            'subjects' => $subjects
        ]);
    }

    /**
     * Get students for attendance (AJAX)
     */
    public function getStudents(Request $request)
    {
        $request->validate([
            'class_id'      => 'required|exists:classes,id',
            'section_id'    => 'required|exists:sections,id',
            'date'          => 'required|date'
        ]);

        $classId    = $request->input('class_id');
        $sectionId  = $request->input('section_id');
        $date       = $request->input('date');
        $subjectId  = $request->input('subject_id');

        // Get class and section details
        $class = Classes::findOrFail($classId);
        $section = Section::findOrFail($sectionId);

        // Get students in this class/section
        $students = StudentProfile::with(['student'])
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            // ->where('school_id', auth()->user()->school_id)
            ->orderBy('admission_no')
            ->get();

        // Get existing attendance for this date if any
        $existingAttendance = [];

        // Find timetable entry if this is subject-wise attendance
        $timetableId = null;
        if ($subjectId) {
            $dayOfWeek = strtolower(date('l', strtotime($date)));
            $timetable = TimeTable::where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->where('subject_id', $subjectId)
                ->where('day_of_week', $dayOfWeek)
                ->where('school_id', auth()->user()->school_id)
                ->first();

            $timetableId = $timetable ? $timetable->id : null;
        }

        $session = AttendanceSession::where('time_table_id', $timetableId)
            ->whereDate('date', $date)
            ->first();

        if ($session) {
            $existingAttendance = $session->attendances()
                ->select('user_id', 'status', 'remarks')
                ->get()
                ->keyBy('user_id')
                ->toArray();
        }

        return response()->json([
            'class' => $class,
            'section' => $section,
            'students' => $students,
            'existingAttendance' => $existingAttendance
        ]);
    }


    /**
     * Store attendance data
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
            'status' => 'required|in:draft,submitted',
            'attendance' => 'required|array'
        ]);

        DB::beginTransaction();

        try {

            $school_id = School::first();
            $classId = $request->input('class_id');
            $sectionId = $request->input('section_id');
            $date = $request->input('date');
            $subjectId = $request->input('subject_id');
            // $sessionType = $request->input('session_type');
            $status = $request->input('status');
            $attendanceData = $request->input('attendance');

            // Find timetable entry if this is subject-wise attendance
            $timetableId = null;

            $dayOfWeek = strtolower(date('l', strtotime($date)));
            $timetable = TimeTable::where('class_id', $classId)
                ->where('section_id', $sectionId)
                // ->where('subject_id', $subjectId)
                ->where('day_of_week', $dayOfWeek)
                ->where('school_id', auth()->user()->school_id ?? $school_id->id)
                ->first();

            $timetableId = $timetable ? $timetable->id : null;
            // Create or update attendance session
            $session = AttendanceSession::updateOrCreate(
                [
                    'school_id' => auth()->user()->school_id ?? $school_id->id,
                    'time_table_id' => $timetableId,
                    'date' => $date,
                ],
                [
                    'recorded_by'   => auth()->id(),
                    'notes'         => "Full day",
                    'status'        => $status === 'submitted' ? 'submitted' : 'draft'
                ]
            );

            // Process each student's attendance
            foreach ($attendanceData as $studentAttendance) {
                if (empty($studentAttendance['status'])) {
                    continue;
                }

                Attendance::updateOrCreate(
                    [
                        'session_id' => $session->id,
                        'user_id' => $studentAttendance['student_id']
                    ],
                    [
                        'status' => $studentAttendance['status'],
                        'remarks' => $studentAttendance['remarks'] ?? null
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Attendance saved successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save attendance: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to find timetable ID for subject-wise attendance
     */
    private function getTimetableId($classId, $sectionId, $subjectId, $date)
    {
        $dayOfWeek = strtolower(date('l', strtotime($date)));

        $timetable = TimeTable::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->where('subject_id', $subjectId)
            ->where('day_of_week', $dayOfWeek)
            // ->where('school_id', auth()->user()->school_id)
            ->first();

        return $timetable ? $timetable->id : null;
    }

    public function checkClasses(Request $request)
    {
        $date = $request->input('date');
        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');

        $dayOfWeek = strtolower(date('l', strtotime($date)));

        // Query your timetable to check for classes on this date
        $hasClasses = Timetable::where('day_of_week', $dayOfWeek)
            ->where('class_id', $classId)->where('section_id', $sectionId)->exists();

        return response()->json([
            'has_classes' => $hasClasses,
            'date' => $date
        ]);
    }


    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
