<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamScheduleController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id;
    }

    public function create(Exam $exam)
    {
        $branchId = $this->branchId();
        $classes  = Classes::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->orderBy('numeric_value')->get();
        return view('app.exams.schedule.create', compact('exam', 'classes'));
    }

    /**
     * Curriculum subjects of a class (AJAX, for the schedule subject dropdown).
     */
    public function getSubjects(Request $request, Exam $exam)
    {
        $request->validate(['class_id' => 'required|integer']);

        $branchId = $this->branchId();

        $class = Classes::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->with('subjects:id,name,code')
            ->findOrFail($request->class_id);

        $subjects = $class->subjects
            ->map(fn ($s) => ['id' => $s->id, 'name' => $s->name, 'code' => $s->code])
            ->values();

        return response()->json(['subjects' => $subjects]);
    }

    public function store(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'class_id'      => 'required|exists:classes,id',
            'subject_id'    => 'required|exists:subjects,id',
            'exam_date'     => 'required|date',
            'start_time'    => 'nullable|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i|after:start_time',
            'room_number'   => 'nullable|string|max:20',
            'max_marks'     => 'nullable|integer|min:1',
            'passing_marks' => 'nullable|integer|min:1|lte:max_marks',
        ], [
            'class_id.required'      => 'Please select a class.',
            'subject_id.required'    => 'Please select a subject.',
            'exam_date.required'     => 'Please choose the exam date.',
            'start_time.date_format' => 'Start time must be a valid time (HH:MM).',
            'end_time.date_format'   => 'End time must be a valid time (HH:MM).',
            'end_time.after'         => 'End time must be later than the start time.',
            'passing_marks.lte'      => 'Passing marks cannot be greater than max marks.',
        ]);

        $data['branch_id'] = $this->branchId();
        $data['exam_id']   = $exam->id;

        ExamSchedule::create($data);

        return redirect()->route('exams.show', $exam)
            ->with('message', 'Schedule entry added.')
            ->with('alert-type', 'success');
    }

    public function edit(Exam $exam, ExamSchedule $schedule)
    {
        $branchId = $this->branchId();
        $classes  = Classes::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->orderBy('numeric_value')->get();
        $subjects = Subject::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->orderBy('name')->get();
        return view('app.exams.schedule.edit', compact('exam', 'schedule', 'classes', 'subjects'));
    }

    public function update(Request $request, Exam $exam, ExamSchedule $schedule)
    {
        $data = $request->validate([
            'class_id'      => 'required|exists:classes,id',
            'subject_id'    => 'required|exists:subjects,id',
            'exam_date'     => 'required|date',
            'start_time'    => 'nullable|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i|after:start_time',
            'room_number'   => 'nullable|string|max:20',
            'max_marks'     => 'nullable|integer|min:1',
            'passing_marks' => 'nullable|integer|min:1',
        ]);

        $schedule->update($data);

        return redirect()->route('exams.show', $exam)
            ->with('message', 'Schedule updated.')
            ->with('alert-type', 'success');
    }

    public function destroy(Exam $exam, ExamSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('exams.show', $exam)
            ->with('message', 'Schedule entry removed.')
            ->with('alert-type', 'success');
    }
}
