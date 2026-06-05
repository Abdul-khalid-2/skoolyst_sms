<?php

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamSchedule;
use App\Models\Section;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamResultController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index(Exam $exam, Request $request)
    {
        $query = ExamResult::where('exam_id', $exam->id)
            ->with(['student', 'subject']);

        if ($request->filled('class_id')) {
            $studentIds = StudentProfile::where('class_id', $request->class_id)->pluck('student_id');
            $query->whereIn('student_id', $studentIds);
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $results = $query->orderBy('subject_id')->orderBy('student_id')->paginate(30)->withQueryString();

        // Stats
        $total    = ExamResult::where('exam_id', $exam->id)->count();
        $passed   = ExamResult::where('exam_id', $exam->id)->where('marks_obtained', '>=', 40)->count();
        $failed   = $total - $passed;
        $avgMarks = ExamResult::where('exam_id', $exam->id)->avg('marks_obtained');

        $classes  = Classes::orderBy('numeric_value')->get(['id', 'name']);
        $subjects = \App\Models\Subject::orderBy('name')->get(['id', 'name']);

        return view('app.exams.results.index', compact(
            'exam', 'results', 'total', 'passed', 'failed', 'avgMarks', 'classes', 'subjects'
        ));
    }

    public function enter(Exam $exam)
    {
        $classes  = Classes::orderBy('numeric_value')->get();
        $sections = Section::orderBy('name')->get();
        return view('app.exams.results.enter', compact('exam', 'classes', 'sections'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'results'    => 'required|array',
        ]);

        $branchId  = $this->branchId();
        $classId   = $request->class_id;
        $subjectId = $request->subject_id;
        $saved     = 0;

        // Find max_marks from schedule
        $schedule    = ExamSchedule::where('exam_id', $exam->id)
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->first();
        $maxMarks    = $schedule?->max_marks ?? 100;
        $passMarks   = $schedule?->passing_marks ?? 40;

        DB::transaction(function () use ($request, $exam, $branchId, $subjectId, $maxMarks, $passMarks, &$saved) {
            foreach ($request->results as $studentId => $data) {
                if (! isset($data['marks']) || $data['marks'] === '') continue;

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

        return redirect()->route('exams.results.index', $exam)
            ->with('message', "{$saved} result(s) saved successfully.")
            ->with('alert-type', 'success');
    }

    private function calcGrade(float $marks, int $max = 100): string
    {
        $pct = ($max > 0) ? ($marks / $max) * 100 : 0;
        return match(true) {
            $pct >= 90 => 'A+',
            $pct >= 80 => 'A',
            $pct >= 70 => 'B',
            $pct >= 60 => 'C',
            $pct >= 50 => 'D',
            default    => 'F',
        };
    }
}
