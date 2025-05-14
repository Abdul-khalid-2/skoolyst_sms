<?php

namespace App\Http\Controllers\Timetable;

use App\Http\Controllers\Controller;
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
        $timetables = [];

        // Get all classes with their sections for the current school
        $classes = Classes::with('sections')
            // ->where('school_id', auth()->user()->school_id)
            ->get();

        foreach ($classes as $class) {
            foreach ($class->sections as $section) {
                $timetableEntries = TimeTable::with(['subject', 'teacher'])
                    ->where('class_id', $class->id)
                    ->where('section_id', $section->id)
                    ->where('school_id', auth()->user()->school_id ?? 1)
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
                            'event' => $entry->break_name,
                            'start' => \Carbon\Carbon::parse($entry->start_time)->format('h:i A'),
                            'end' => \Carbon\Carbon::parse($entry->end_time)->format('h:i A'),
                            'room' => $entry->room_number
                        ];
                    } else {
                        $periods[$periodName][$day] = [
                            'teacher' => $entry->teacher->name ?? 'N/A',
                            'teacher_id' => $entry->teacher->id ?? 'N/A',
                            'subject' => $entry->subject->name ?? 'N/A',
                            'subject_id' => $entry->subject->id ?? 'N/A',
                            'start' => \Carbon\Carbon::parse($entry->start_time)->format('h:i A'),
                            'end' => \Carbon\Carbon::parse($entry->end_time)->format('h:i A'),

                            'room' => $entry->room_number
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

        $teachers = User::role('teacher')->get();
        $subjects = Subject::get();

        return view('app.timetable.index', compact('timetables', 'teachers', 'subjects'));
    }


    public function create()
    {
        $classes = Classes::get();
        $sections = Section::where('school_id', auth()->user()->school_id)->get();
        $subjects = Subject::where('school_id', auth()->user()->school_id)->get();
        $teachers = User::role('teacher')->get();

        return view('app.timetable.create', compact('classes', 'sections', 'subjects', 'teachers'));
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
                $timeTableData = [
                    'school_id' => auth()->user()->school_id ?? 1,
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
            \Log::error('Timetable creation failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error creating timetable: ' . $e->getMessage());
        }
    }


    public function edit($id) {}


    public function update(Request $request, $id) {}

    public function destroy($id) {}


    public function create_schedule()
    {
        $teachers = User::with('teacherProfile')->role('teacher')->get();
        $subjects = Subject::get();
        return response()->json([
            'teachers' => $teachers,
            'subjects' => $subjects,
        ]);
    }
    public function store_schedule(Request $request)
    {
        $isBreak = isset($request->is_break) ? 1 : 0;

        $timetable = [
            'school_id'     =>    "1",
            'class_id'      =>    $request->class_id ?? "",
            'section_id'    =>    $request->section_id ?? "",
            'subject_id'    =>    $request->subject ?? "",
            'teacher_id'    =>    $request->teacher ?? "",
            'day_of_week'   =>    $request->day ?? "",
            'period_name'   =>    $request->period ?? "",
            'start_time'    =>    $request->start ?? "",
            'end_time'      =>    $request->end ?? "",
            'room_number'   =>    $request->room ?? "",
            'is_break'      =>    $isBreak,
            'break_name'    =>    null,
            'is_recurring'  =>    false,
        ];
        $data = TimeTable::create($timetable);
        return response()->json([
            'message' => 'schedul added successfull',
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
