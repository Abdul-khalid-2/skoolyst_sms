<?php

namespace App\Http\Controllers\Timetable;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TeacherSubject;
use App\Models\TimeTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{

    public function index()
    {

        $branchId = auth()->user()->branch_id;
        $timetables = [];

        $classes = Classes::with('sections')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();

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

        return view('app.timetable.index', compact('timetables', 'teachers', 'subjects'));
    }


    public function create()
    {
        $branchId = auth()->user()->branch_id;
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
                $branchId = auth()->user()->branch_id;
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
                $teacherSubject = TeacherSubject::where([
                    'subject_id' => $period['subject_id'] ?? null,
                    'teacher_id' => $period['teacher_id'] ?? null,
                ])->first();

                if ($teacherSubject) {
                    // If record exists with matching subject_id and teacher_id
                    if ($teacherSubject->class_id === null || $teacherSubject->class_id == $validated['class_id']) {
                        // Update if class_id is null or matches
                        $teacherSubject->update(['class_id' => $validated['class_id']]);
                    } else {
                        // Create new record if class_id doesn't match
                        TeacherSubject::create([
                            'class_id' => $validated['class_id'],
                            'subject_id' => $period['subject_id'],
                            'teacher_id' => $period['teacher_id'],
                        ]);
                    }
                } else {
                    // Create new record if no matching record found
                    TeacherSubject::create([
                        'class_id' => $validated['class_id'],
                        'subject_id' => $period['subject_id'],
                        'teacher_id' => $period['teacher_id'],
                    ]);
                }

                // Create the entry
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

    private function buildSchedulePayload(Request $request, bool $isBreak): array
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

        $branchId = auth()->user()->branch_id;

        return [
            'branch_id' => $branchId,
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

        $branchId = auth()->user()->branch_id;
        $entry = TimeTable::where('branch_id', $branchId)->findOrFail($validated['entry_id']);
        $isBreak = $request->input('type') === 'event';

        $payload = $this->buildSchedulePayload($request, $isBreak);
        $entry->update($payload);

        if (! $isBreak) {
            $this->syncTeacherSubject(
                (int) $payload['class_id'],
                (int) $payload['subject_id'],
                (int) $payload['teacher_id']
            );
        }

        return response()->json([
            'message' => 'Schedule updated successfully',
            'data' => $entry->fresh(['subject', 'teacher']),
        ]);
    }

    private function syncTeacherSubject(int $classId, ?int $subjectId, ?int $teacherId): void
    {
        if (! $subjectId || ! $teacherId) {
            return;
        }

        $teacherSubject = TeacherSubject::where([
            'subject_id' => $subjectId,
            'teacher_id' => $teacherId,
        ])->first();

        if ($teacherSubject) {
            if ($teacherSubject->class_id === null || $teacherSubject->class_id == $classId) {
                $teacherSubject->update(['class_id' => $classId]);
            } else {
                TeacherSubject::create([
                    'class_id' => $classId,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                ]);
            }

            return;
        }

        TeacherSubject::create([
            'class_id' => $classId,
            'subject_id' => $subjectId,
            'teacher_id' => $teacherId,
        ]);
    }


    public function create_schedule()
    {
        $branchId = auth()->user()->branch_id;
        $teachers = User::with('teacherProfile')->role('teacher')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();
        $subjects = Subject::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->get();
        return response()->json([
            'teachers' => $teachers,
            'subjects' => $subjects,
        ]);
    }

    public function store_schedule(Request $request)
    {
        $isBreak = $request->input('type') === 'event';
        $payload = $this->buildSchedulePayload($request, $isBreak);
        $data = TimeTable::create($payload);

        if (! $isBreak) {
            $this->syncTeacherSubject(
                (int) $payload['class_id'],
                (int) $payload['subject_id'],
                (int) $payload['teacher_id']
            );
        }

        return response()->json([
            'message' => 'Schedule added successfully',
            'data' => $data,
        ]);
    }


    public function getTeachersBySubject(Request $request)
    {
        $subjectId  = $request->input('subject_id');
        $classId    = $request->input('class_id');

        // Get assigned teachers for this subject and class
        $assignedTeachers = TeacherSubject::where('subject_id', $subjectId)
            ->where('class_id', $classId)
            ->with('teacher.teacherProfile')
            ->get();



        // Extract teacher details
        $teachers = $assignedTeachers->map(function ($assign) {
            return $assign->teacher;
        });

        // Get the first assigned teacher ID (if any)
        $assignedTeacherId = $assignedTeachers->first() ? $assignedTeachers->first()->teacher_id : null;

        return response()->json([
            'teachers' => $teachers,
            'assigned_teacher_id' => $assignedTeacherId
        ]);
    }
}


