<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamSchedule;
use App\Models\User;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResultController extends Controller
{
    public function index(User $student): View
    {
        $this->authorize('view', $student);

        $student->load(['studentProfile.class', 'studentProfile.section']);
        $classId = $student->studentProfile?->class_id;

        $results = ExamResult::where('student_id', $student->id)
            ->whereHas('exam', fn ($q) => $q->where('is_published', true))
            ->with(['exam', 'subject'])
            ->get();

        $schedules = $this->schedulesFor($results->pluck('exam_id')->unique()->all(), $classId);

        $exams = $results
            ->groupBy('exam_id')
            ->map(function ($examResults) use ($schedules) {
                $exam = $examResults->first()->exam;
                $summary = $this->summarise($examResults, $schedules);

                return (object) array_merge([
                    'exam' => $exam,
                    'subject_count' => $examResults->count(),
                ], $summary);
            })
            ->sortByDesc(fn ($row) => $row->exam->start_date)
            ->values();

        $children = auth()->user()->children()->orderBy('name')->get();

        return view('app.parent.results.index', compact('student', 'children', 'exams'));
    }

    public function show(User $student, Exam $exam): View
    {
        $this->authorize('view', $student);
        abort_unless($exam->is_published, 404);

        $student->load(['studentProfile.class', 'studentProfile.section']);
        $classId = $student->studentProfile?->class_id;

        $results = ExamResult::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->with('subject')
            ->get();

        if ($results->isEmpty()) {
            throw new NotFoundHttpException('No results found for this exam.');
        }

        $schedules = $this->schedulesFor([$exam->id], $classId);

        $rows = $results->map(function ($result) use ($schedules) {
            $schedule  = $schedules->get($result->exam_id.'-'.$result->subject_id);
            $maxMarks  = (float) ($schedule?->max_marks ?? 100);
            $passMarks = (float) ($schedule?->passing_marks ?? 40);
            $marks     = (float) $result->marks_obtained;

            return (object) [
                'subject'    => $result->subject?->name ?? '—',
                'marks'      => $marks,
                'max_marks'  => $maxMarks,
                'pass_marks' => $passMarks,
                'percentage' => $maxMarks > 0 ? round(($marks / $maxMarks) * 100, 1) : 0,
                'grade'      => $result->grade ?? $this->calcGrade($marks, $maxMarks),
                'passed'     => $marks >= $passMarks,
                'remarks'    => $result->remarks,
            ];
        })->sortBy('subject')->values();

        $summary = $this->summarise($results, $schedules);

        $backUrl = route('parent.children.results', $student->id);

        return view('app.student.results.show', compact('student', 'exam', 'rows', 'summary', 'backUrl'));
    }

    private function schedulesFor(array $examIds, ?int $classId)
    {
        if (empty($examIds)) {
            return collect();
        }

        return ExamSchedule::whereIn('exam_id', $examIds)
            ->when($classId, fn ($q) => $q->where('class_id', $classId))
            ->get()
            ->keyBy(fn ($s) => $s->exam_id.'-'.$s->subject_id);
    }

    private function summarise($examResults, $schedules): array
    {
        $totalObtained = 0;
        $totalMax = 0;
        $allPassed = true;

        foreach ($examResults as $result) {
            $schedule  = $schedules->get($result->exam_id.'-'.$result->subject_id);
            $maxMarks  = (float) ($schedule?->max_marks ?? 100);
            $passMarks = (float) ($schedule?->passing_marks ?? 40);
            $marks     = (float) $result->marks_obtained;

            $totalObtained += $marks;
            $totalMax      += $maxMarks;

            if ($marks < $passMarks) {
                $allPassed = false;
            }
        }

        $percentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 1) : 0;

        return [
            'total_obtained' => $totalObtained,
            'total_max'      => $totalMax,
            'percentage'     => $percentage,
            'grade'          => $this->calcGrade($totalObtained, $totalMax),
            'passed'         => $allPassed,
        ];
    }

    private function calcGrade(float $marks, float $max = 100): string
    {
        $pct = ($max > 0) ? ($marks / $max) * 100 : 0;

        return match (true) {
            $pct >= 90 => 'A+',
            $pct >= 80 => 'A',
            $pct >= 70 => 'B',
            $pct >= 60 => 'C',
            $pct >= 50 => 'D',
            default    => 'F',
        };
    }
}
