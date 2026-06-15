<?php

namespace App\Http\Controllers\Timetable;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SectionSubjectTeacher;
use App\Models\TimeTable;
use App\Models\User;
use App\Services\Academic\AssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TimetableController extends Controller
{
    protected ?int $branchId;

    public function __construct()
    {
        $user = auth()->user();
        $this->branchId = $user && $user->hasRole('super-admin') ? null : $user?->branch_id;
    }

    public function index()
    {
        $branchId = $this->branchId;
        $timetables = [];

        $classes = Classes::with(['sections', 'subjects:id,name,code'])
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();

        $classSubjects = $classes->mapWithKeys(fn ($c) => [
            $c->id => $c->subjects->map(fn ($s) => [
                'id'   => $s->id,
                'name' => $s->name,
                'code' => $s->code,
            ])->values(),
        ]);

        foreach ($classes as $class) {
            foreach ($class->sections as $section) {
                $timetableEntries = TimeTable::with(['subject', 'teacher'])
                    ->where('class_id', $class->id)
                    ->where('section_id', $section->id)
                    ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                    ->orderBy('day_of_week')
                    ->orderBy('start_time')
                    ->get();

                $periods = [];
                foreach ($timetableEntries as $entry) {
                    $day = $entry->day_of_week;
                    $periodName = $entry->period_name;

                    if (!isset($periods[$periodName])) {
                        $periods[$periodName] = [];
                    }

                    if ($entry->is_break) {
                        $periods[$periodName][$day] = [
                            'id' => $entry->id,
                            'event' => $entry->break_name,
                            'start' => \Carbon\Carbon::parse($entry->start_time)->format('h:i A'),
                            'end' => \Carbon\Carbon::parse($entry->end_time)->format('h:i A'),
                            'start_raw' => \Carbon\Carbon::parse($entry->start_time)->format('H:i'),
                            'end_raw' => \Carbon\Carbon::parse($entry->end_time)->format('H:i'),
                            'room' => $entry->room_number,
                        ];
                    } else {
                        $periods[$periodName][$day] = [
                            'id' => $entry->id,
                            'teacher' => $entry->teacher->name ?? 'N/A',
                            'teacher_id' => $entry->teacher->id ?? null,
                            'subject' => $entry->subject->name ?? 'N/A',
                            'subject_id' => $entry->subject->id ?? null,
                            'start' => \Carbon\Carbon::parse($entry->start_time)->format('h:i A'),
                            'end' => \Carbon\Carbon::parse($entry->end_time)->format('h:i A'),
                            'start_raw' => \Carbon\Carbon::parse($entry->start_time)->format('H:i'),
                            'end_raw' => \Carbon\Carbon::parse($entry->end_time)->format('H:i'),
                            'room' => $entry->room_number,
                        ];
                    }
                }


                $timetables[] = [
                    'class_id' => $class->id,
                    'section_id' => $section->id,
                    'class_name' => $class->name . ' (Section ' . $section->name . ')',
                    'periods' => $periods
                ];
            }
        }

        $teachers = User::role('teacher')->when($branchId, fn ($q) => $q->where('branch_id', $branchId))->get();
        $subjects = Subject::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->get();

        return view('app.timetable.index', compact('timetables', 'teachers', 'subjects', 'classSubjects'));
    }


    public function create()
    {
        $branchId = $this->branchId;
        $classes  = Classes::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->with('subjects:id,name,code')
            ->get();
        $sections = Section::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->get();
        $subjects = Subject::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->get();
        $teachers = User::role('teacher')->when($branchId, fn ($q) => $q->where('branch_id', $branchId))->get();

        // class_id => [{id, name, code}] — each class's curriculum, for filtering the subject picker.
        $classSubjects = $classes->mapWithKeys(fn ($c) => [
            $c->id => $c->subjects->map(fn ($s) => ['id' => $s->id, 'name' => $s->name, 'code' => $s->code])->values(),
        ]);

        return view('app.timetable.create', compact('classes', 'sections', 'subjects', 'teachers', 'classSubjects'));
    }



    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'class_id' => 'required|exists:classes,id',
        //     'section_id' => 'required|exists:sections,id',
        //     'periods' => 'required|array|min:1',
        //     'periods.*.day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
        //     'periods.*.period_name' => 'required|string|max:50',
        //     'periods.*.start_time' => 'required|date_format:H:i',
        //     'periods.*.end_time' => 'required|date_format:H:i|after:periods.*.start_time',
        //     'periods.*.subject_id' => 'nullable|required_unless:periods.*.is_break,true|exists:subjects,id',
        //     'periods.*.teacher_id' => 'nullable|required_unless:periods.*.is_break,true|exists:users,id',
        //     'periods.*.room_number' => 'nullable|string|max:20',
        //     'periods.*.is_break' => 'sometimes',
        //     'periods.*.break_name' => 'nullable|required_if:periods.*.is_break,true|string|max:50',
        // ]);
        $validated = $request->validate([
            'class_id' => 'required',
            'section_id' => 'required',
            'periods' => 'required',
            'periods.*.day' => 'required',
            'periods.*.period_name' => 'required',
            'periods.*.start_time' => 'required',
            'periods.*.end_time' => 'required',
            'periods.*.subject_id' => 'nullable',
            'periods.*.teacher_id' => 'nullable',
            'periods.*.room_number' => 'nullable',
            'periods.*.is_break' => 'sometimes',
            'periods.*.break_name' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            // Delete existing timetable first
            TimeTable::where('class_id', $validated['class_id'])
                ->where('section_id', $validated['section_id'])
                ->delete();

            // Track existing time slots to prevent overlaps
            $timeSlots = [];
            $branchId = $this->resolveBranchId(
                (int) $validated['class_id'],
                (int) $validated['section_id'],
            );

            foreach ($validated['periods'] as $index => $period) {
                // Validate period name exists
                if (!isset($period['period_name'])) {
                    throw new \Exception("Period name is missing for period {$index}");
                }

                // Check for time slot conflicts
                $timeSlotKey = "{$validated['class_id']}-{$validated['section_id']}-{$period['day']}-{$period['start_time']}";

                if (isset($timeSlots[$timeSlotKey])) {
                    throw new \Exception("Duplicate time slot detected for {$period['day']} at {$period['start_time']}");
                }

                $timeSlots[$timeSlotKey] = true;

                // Prepare data
                $isBreak = isset($period['is_break']) ? 1 : 0;
                $timeTableData = [
                    'branch_id' => $branchId,
                    'class_id' => $validated['class_id'],
                    'section_id' => $validated['section_id'],
                    'day_of_week' => $period['day'],
                    'period_name' => $period['period_name'],
                    'start_time' => $period['start_time'],
                    'end_time' => $period['end_time'],
                    'room_number' => $period['room_number'] ?? null,
                    'is_recurring' => true,
                    'is_break' => $isBreak,
                    'break_name' => $isBreak ? ($period['break_name'] ?? null) : null,
                    'subject_id' => $isBreak ? null : ($period['subject_id'] ?? null),
                    'teacher_id' => $isBreak ? null : ($period['teacher_id'] ?? null),
                ];
                if (! $isBreak && ! empty($period['subject_id']) && ! empty($period['teacher_id'])) {
                    app(AssignmentService::class)->validateTimetableSlot(
                        (int) $validated['class_id'],
                        (int) $validated['section_id'],
                        (int) $period['subject_id'],
                        (int) $period['teacher_id'],
                    );
                }

                TimeTable::create($timeTableData);
            }

            DB::commit();
            return redirect()->route('admin.timetable.index')->with('success', 'Timetable created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error creating timetable: ' . $e->getMessage());
        }
    }


    public function edit($id) {}


    public function update(Request $request, $id)
    {
        $request->merge(['entry_id' => $id]);

        return $this->update_schedule($request);
    }

    public function destroy($id) {}

    private function findConflictingScheduleSlot(array $payload, ?int $ignoreEntryId = null): ?TimeTable
    {
        $query = TimeTable::withTrashed()
            ->where('class_id', $payload['class_id'])
            ->where('section_id', $payload['section_id'])
            ->where('day_of_week', $payload['day_of_week'])
            ->where('start_time', $payload['start_time']);

        if ($ignoreEntryId) {
            $query->where('id', '!=', $ignoreEntryId);
        }

        return $query->first();
    }

    private function assertScheduleSlotAvailable(array $payload, ?int $ignoreEntryId = null): void
    {
        $existing = $this->findConflictingScheduleSlot($payload, $ignoreEntryId);

        if ($existing && ! $existing->trashed()) {
            $time = strlen($payload['start_time']) >= 5
                ? substr($payload['start_time'], 0, 5)
                : $payload['start_time'];

            throw ValidationException::withMessages([
                'start' => [
                    "A schedule already exists on {$payload['day_of_week']} at {$time} for this class and section. Update that period or choose a different start time.",
                ],
            ]);
        }
    }

    private function persistScheduleSlot(array $payload, ?TimeTable $entry = null): TimeTable
    {
        if ($entry) {
            $this->assertScheduleSlotAvailable($payload, $entry->id);
            $entry->update($payload);

            return $entry->fresh(['subject', 'teacher']);
        }

        $existing = $this->findConflictingScheduleSlot($payload);

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
                $existing->update($payload);

                return $existing->fresh(['subject', 'teacher']);
            }

            $time = strlen($payload['start_time']) >= 5
                ? substr($payload['start_time'], 0, 5)
                : $payload['start_time'];

            throw ValidationException::withMessages([
                'start' => [
                    "A schedule already exists on {$payload['day_of_week']} at {$time} for this class and section. Use Update on the existing period instead.",
                ],
            ]);
        }

        return TimeTable::create($payload)->load(['subject', 'teacher']);
    }

    private function validateScheduleTimes(string $start, string $end): void
    {
        $startMinutes = ((int) substr($start, 0, 2) * 60) + (int) substr($start, 3, 2);
        $endMinutes = ((int) substr($end, 0, 2) * 60) + (int) substr($end, 3, 2);

        if ($endMinutes <= $startMinutes) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'end' => ['End time must be at least 1 minute after start time.'],
            ]);
        }
    }

    private function buildSchedulePayload(Request $request, bool $isBreak, ?TimeTable $existing = null): array
    {
        $request->merge([
            'subject' => $request->input('subject') ?: null,
            'teacher' => $request->input('teacher') ?: null,
            'event' => $request->input('event') ?: null,
            'room' => $request->input('room') ?: null,
        ]);

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'day' => 'required|string|max:20',
            'period' => 'required|string|max:50',
            'type' => 'required|in:class,event',
            'subject' => 'nullable|exists:subjects,id',
            'teacher' => 'nullable|exists:users,id',
            'event' => 'nullable|string|max:255',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'room' => 'nullable|string|max:20',
        ]);

        $this->validateScheduleTimes($validated['start'], $validated['end']);

        if ($isBreak && empty($validated['event'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'event' => ['Event label is required for break/event schedules.'],
            ]);
        }

        if (! $isBreak && (empty($validated['subject']) || empty($validated['teacher']))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'subject' => ['Subject and teacher are required for class schedules.'],
            ]);
        }

        return [
            'branch_id' => $this->resolveBranchId(
                (int) $validated['class_id'],
                (int) $validated['section_id'],
                $existing?->branch_id,
            ),
            'class_id' => $validated['class_id'],
            'section_id' => $validated['section_id'],
            'day_of_week' => $validated['day'],
            'period_name' => $validated['period'],
            'start_time' => $validated['start'],
            'end_time' => $validated['end'],
            'room_number' => $validated['room'] ?? null,
            'is_break' => $isBreak ? 1 : 0,
            'break_name' => $isBreak ? $validated['event'] : null,
            'subject_id' => $isBreak ? null : $validated['subject'],
            'teacher_id' => $isBreak ? null : $validated['teacher'],
            'is_recurring' => true,
        ];
    }

    public function update_schedule(Request $request)
    {
        $validated = $request->validate([
            'entry_id' => 'required|exists:time_tables,id',
        ]);

        $entry = TimeTable::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->findOrFail($validated['entry_id']);
        $isBreak = $request->input('type') === 'event';

        $payload = $this->buildSchedulePayload($request, $isBreak, $entry);

        if (! $isBreak) {
            app(AssignmentService::class)->validateTimetableSlot(
                (int) $payload['class_id'],
                (int) $payload['section_id'],
                (int) $payload['subject_id'],
                (int) $payload['teacher_id'],
            );
        }

        $entry = $this->persistScheduleSlot($payload, $entry);

        return response()->json([
            'message' => 'Schedule updated successfully',
            'data' => $entry,
        ]);
    }

    public function create_schedule(Request $request)
    {
        $branchId = $this->branchId;
        $teachers = User::with('teacherProfile')->role('teacher')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();

        $subjectsQuery = Subject::when($branchId, fn ($q) => $q->where('branch_id', $branchId));

        if ($request->filled('class_id')) {
            $class = Classes::with('subjects:id,name,code')
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->find($request->integer('class_id'));

            $subjects = $class ? $class->subjects : collect();
        } else {
            $subjects = $subjectsQuery->orderBy('name')->get();
        }

        return response()->json([
            'teachers' => $teachers,
            'subjects' => $subjects,
        ]);
    }

    public function store_schedule(Request $request)
    {
        $isBreak = $request->input('type') === 'event';
        $payload = $this->buildSchedulePayload($request, $isBreak);

        if (! $isBreak) {
            app(AssignmentService::class)->validateTimetableSlot(
                (int) $payload['class_id'],
                (int) $payload['section_id'],
                (int) $payload['subject_id'],
                (int) $payload['teacher_id'],
            );
        }

        $data = $this->persistScheduleSlot($payload);

        return response()->json([
            'message' => 'Schedule added successfully',
            'data' => $data,
        ]);
    }


    public function getTeachersBySubject(Request $request)
    {
        $subjectId = $request->input('subject_id');
        $sectionId = $request->integer('section_id') ?: null;

        $branchId = $this->branchId;
        $service  = app(AssignmentService::class);

        // Timetable picks from teacher capabilities (teacher_subjects), not section allocation only.
        $teachers = $service->getEligibleTeachersForSubject((int) $subjectId, $branchId);

        $assignedTeacherId = $sectionId
            ? SectionSubjectTeacher::where('section_id', $sectionId)
                ->where('subject_id', $subjectId)
                ->value('teacher_id')
            : null;

        return response()->json([
            'teachers'            => $teachers,
            'assigned_teacher_id' => $assignedTeacherId,
        ]);
    }

    /**
     * Branch for timetable writes. Super-admins inherit branch from the class/section.
     */
    private function resolveBranchId(int $classId, int $sectionId, ?int $existingBranchId = null): int
    {
        if ($this->branchId) {
            return (int) $this->branchId;
        }

        if ($existingBranchId) {
            return (int) $existingBranchId;
        }

        $section = Section::withoutBranchScope()->find($sectionId);
        if ($section?->branch_id) {
            return (int) $section->branch_id;
        }

        $class = Classes::withoutBranchScope()->find($classId);
        if ($class?->branch_id) {
            return (int) $class->branch_id;
        }

        throw ValidationException::withMessages([
            'class_id' => ['Unable to determine branch for this schedule.'],
        ]);
    }
}


