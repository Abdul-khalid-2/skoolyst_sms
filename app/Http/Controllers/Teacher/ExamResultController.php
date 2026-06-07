<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\ScopesTeacherAssignments;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamSchedule;
use App\Models\Section;
use App\Models\StudentProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ExamResultController extends Controller
{
    use ScopesTeacherAssignments;

    /**
     * Exams where the teacher has scheduled papers or can enter marks.
     */
    public function index(): View
    {
        $branchId          = $this->branchId();
        $allowedClassIds   = $this->allowedClassIds();
        $allowedSubjectIds = $this->allowedSubjectIds();

        $exams = collect();

        if ($allowedClassIds->isNotEmpty() && $allowedSubjectIds->isNotEmpty()) {
            $examIds = ExamSchedule::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->whereIn('class_id', $allowedClassIds)
                ->whereIn('subject_id', $allowedSubjectIds)
                ->pluck('exam_id')
                ->unique();

            $exams = Exam::whereIn('id', $examIds)
                ->withCount(['schedules', 'results'])
                ->orderByDesc('start_date')
                ->get()
                ->map(function (Exam $exam) {
                    $today        = now()->toDateString();
                    $exam->status = match (true) {
                        $exam->end_date < $today   => 'completed',
                        $exam->start_date > $today => 'upcoming',
                        default                     => 'ongoing',
                    };

                    return $exam;
                });
        }

        return view('app.teacher.exams.marks.index', compact('exams'));
    }

    public function enter(Exam $exam): View
    {
        $branchId = $this->branchId();
        abort_unless(! $branchId || $exam->branch_id === $branchId, 404);

        $allowedClassIds = $this->allowedClassIds();

        $classes = Classes::whereIn('id', $allowedClassIds)
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->orderBy('numeric_value')
            ->get();

        return view('app.teacher.exams.marks.enter', compact('exam', 'classes'));
    }

    public function store(Request $request, Exam $exam): RedirectResponse
    {
        $branchId = $this->branchId();
        abort_unless(! $branchId || $exam->branch_id === $branchId, 404);

        $request->validate([
            'class_id'   => 'required|integer',
            'subject_id' => 'required|integer',
            'results'    => 'required|array',
        ]);

        $classId   = (int) $request->class_id;
        $subjectId = (int) $request->subject_id;

        abort_unless($this->allows($classId), 403, 'You are not assigned to this class.');
        abort_unless($this->allowsSubject($classId, $subjectId), 403, 'You are not assigned to teach this subject.');

        $schedule  = ExamSchedule::where('exam_id', $exam->id)
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->first();
        $maxMarks  = $schedule?->max_marks ?? 100;
        $passMarks = $schedule?->passing_marks ?? 40;
        $saved     = 0;

        DB::transaction(function () use ($request, $exam, $branchId, $subjectId, $maxMarks, &$saved) {
            foreach ($request->results as $studentId => $data) {
                if (! isset($data['marks']) || $data['marks'] === '') {
                    continue;
                }

                $marks = (float) $data['marks'];
                $grade = $data['grade'] ?? $this->calcGrade($marks, $maxMarks);

                ExamResult::updateOrCreate(
                    ['exam_id' => $exam->id, 'student_id' => $studentId, 'subject_id' => $subjectId],
                    [
                        'branch_id'      => $branchId,
                        'marks_obtained' => $marks,
                        'grade'          => $grade,
                        'remarks'        => $data['remarks'] ?? null,
                        'published_at'   => $exam->is_published ? now() : null,
                    ]
                );
                $saved++;
            }
        });

        return redirect()->route('teacher.exams.marks.enter', $exam)
            ->with('message', "{$saved} result(s) saved successfully.")
            ->with('alert-type', 'success');
    }

    public function getSections(Request $request)
    {
        $request->validate(['class_id' => 'required|integer']);

        $classId    = (int) $request->input('class_id');
        $allowedIds = $this->allowedPairs()
            ->where('class_id', $classId)
            ->pluck('section_id')
            ->unique();

        $sections = Section::whereIn('id', $allowedIds)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['sections' => $sections]);
    }

    public function getSubjects(Request $request)
    {
        $request->validate(['class_id' => 'required|integer']);

        $classId = (int) $request->input('class_id');

        abort_unless($this->allows($classId), 403);

        $subjectIds = $this->allowedSubjectIdsForClass($classId);

        $subjects = \App\Models\Subject::whereIn('id', $subjectIds)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['subjects' => $subjects]);
    }

    public function getStudents(Request $request, Exam $exam)
    {
        $request->validate([
            'class_id'   => 'required|integer',
            'section_id' => 'nullable|integer',
            'subject_id' => 'required|integer',
        ]);

        $classId   = (int) $request->class_id;
        $sectionId = $request->filled('section_id') ? (int) $request->section_id : null;
        $subjectId = (int) $request->subject_id;

        abort_unless($this->allows($classId, $sectionId), 403);
        abort_unless($this->allowsSubject($classId, $subjectId), 403);

        $query = StudentProfile::with('student')
            ->where('class_id', $classId);

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        } else {
            $allowedSectionIds = $this->allowedPairs()
                ->where('class_id', $classId)
                ->pluck('section_id');
            $query->whereIn('section_id', $allowedSectionIds);
        }

        $students = $query->orderBy('admission_no')->get();

        $existing = ExamResult::where('exam_id', $exam->id)
            ->where('subject_id', $subjectId)
            ->whereIn('student_id', $students->pluck('student_id'))
            ->get()
            ->keyBy('student_id');

        $schedule = ExamSchedule::where('exam_id', $exam->id)
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->first();

        return response()->json([
            'students'   => $students,
            'existing'   => $existing,
            'max_marks'  => $schedule?->max_marks ?? 100,
            'pass_marks' => $schedule?->passing_marks ?? 40,
        ]);
    }

    private function calcGrade(float $marks, int $max = 100): string
    {
        $pct = ($max > 0) ? ($marks / $max) * 100 : 0;

        return match (true) {
            $pct >= 90 => 'A+',
            $pct >= 80 => 'A',
            $pct >= 70 => 'B',
            $pct >= 60 => 'C',
            $pct >= 50 => 'D',
            default     => 'F',
        };
    }
}
