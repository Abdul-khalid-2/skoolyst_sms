<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\ScopesTeacherAssignments;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Subject;
use App\Models\TimeTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    use ScopesTeacherAssignments;

    /**
     * List class tests (schedules) for subjects and classes the teacher teaches.
     */
    public function index(): View
    {
        $branchId         = $this->branchId();
        $allowedClassIds  = $this->allowedClassIds();
        $allowedSubjectIds = $this->allowedSubjectIds();

        $schedules = collect();

        if ($allowedClassIds->isNotEmpty() && $allowedSubjectIds->isNotEmpty()) {
            $schedules = ExamSchedule::with(['exam', 'subject', 'schoolClass'])
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->whereIn('class_id', $allowedClassIds)
                ->whereIn('subject_id', $allowedSubjectIds)
                ->orderByDesc('exam_date')
                ->orderByDesc('id')
                ->get();
        }

        $stats = [
            'total'     => $schedules->count(),
            'upcoming'  => $schedules->filter(fn ($s) => $s->exam_date >= now()->toDateString())->count(),
            'completed' => $schedules->filter(fn ($s) => $s->exam_date < now()->toDateString())->count(),
        ];

        return view('app.teacher.exams.tests.index', compact('schedules', 'stats'));
    }

    public function create(): View
    {
        $branchId        = $this->branchId();
        $allowedClassIds = $this->allowedClassIds();

        $classes = Classes::whereIn('id', $allowedClassIds)
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->orderBy('numeric_value')
            ->get(['id', 'name']);

        $today = now()->toDateString();
        $exams = Exam::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->where('end_date', '>=', $today)
            ->orderBy('start_date')
            ->get(['id', 'name', 'start_date', 'end_date']);

        return view('app.teacher.exams.tests.create', compact('classes', 'exams'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'exam_id'       => 'required|exists:exams,id',
            'class_id'      => 'required|integer',
            'subject_id'    => 'required|integer',
            'exam_date'     => 'required|date',
            'start_time'    => 'nullable|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i|after:start_time',
            'room_number'   => 'nullable|string|max:20',
            'max_marks'     => 'nullable|integer|min:1',
            'passing_marks' => 'nullable|integer|min:1',
        ]);

        $classId   = (int) $data['class_id'];
        $subjectId = (int) $data['subject_id'];

        abort_unless($this->allows($classId), 403, 'You are not assigned to this class.');
        abort_unless($this->allowsSubject($classId, $subjectId), 403, 'You are not assigned to teach this subject.');

        $branchId = $this->branchId();
        $exam     = Exam::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->findOrFail($data['exam_id']);

        if ($data['exam_date'] < $exam->start_date || $data['exam_date'] > $exam->end_date) {
            return back()
                ->withInput()
                ->with('message', 'Exam date must fall within the selected exam period.')
                ->with('alert-type', 'error');
        }

        ExamSchedule::create([
            'branch_id'     => $branchId,
            'exam_id'       => $exam->id,
            'class_id'      => $classId,
            'subject_id'    => $subjectId,
            'exam_date'     => $data['exam_date'],
            'start_time'    => $data['start_time'] ?? null,
            'end_time'      => $data['end_time'] ?? null,
            'room_number'   => $data['room_number'] ?? null,
            'max_marks'     => $data['max_marks'] ?? 100,
            'passing_marks' => $data['passing_marks'] ?? 40,
        ]);

        return redirect()->route('teacher.exams.tests.show', $exam)
            ->with('message', 'Class test scheduled successfully.')
            ->with('alert-type', 'success');
    }

    public function show(Exam $exam): View
    {
        $branchId          = $this->branchId();
        $allowedClassIds   = $this->allowedClassIds();
        $allowedSubjectIds = $this->allowedSubjectIds();

        abort_unless(! $branchId || $exam->branch_id === $branchId, 404);

        $exam->load(['schedules' => function ($q) use ($allowedClassIds, $allowedSubjectIds) {
            $q->with(['subject', 'schoolClass'])
                ->whereIn('class_id', $allowedClassIds)
                ->whereIn('subject_id', $allowedSubjectIds)
                ->orderBy('exam_date')
                ->orderBy('start_time');
        }]);

        $today        = now()->toDateString();
        $exam->status = match (true) {
            $exam->end_date < $today   => 'completed',
            $exam->start_date > $today => 'upcoming',
            default                     => 'ongoing',
        };

        $resultsCount = $exam->results()
            ->whereHas('student.studentProfile', fn ($q) => $q->whereIn('class_id', $allowedClassIds))
            ->whereIn('subject_id', $allowedSubjectIds)
            ->count();

        return view('app.teacher.exams.tests.show', compact('exam', 'resultsCount'));
    }

    /**
     * Subjects the teacher teaches for a given class (AJAX).
     */
    public function getSubjects(Request $request)
    {
        $request->validate(['class_id' => 'required|integer']);

        $classId = (int) $request->input('class_id');

        abort_unless($this->allows($classId), 403);

        $subjectIds = $this->allowedSubjectIdsForClass($classId);

        $subjects = Subject::whereIn('id', $subjectIds)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['subjects' => $subjects]);
    }

    private function allowedSubjectIds()
    {
        return TimeTable::where('teacher_id', auth()->id())
            ->whereNotNull('subject_id')
            ->pluck('subject_id')
            ->unique()
            ->values();
    }
}
