<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\BookIssue;
use App\Models\ExamResult;
use App\Models\ExamSchedule;
use App\Models\Fee;
use App\Models\Notice;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * The student's personalised dashboard with a snapshot of every module.
     */
    public function index(): View
    {
        $student = auth()->user()->load(['studentProfile.class', 'studentProfile.section']);
        $studentId = $student->id;
        $classId = $student->studentProfile?->class_id;

        return view('app.student.dashboard', [
            'student'      => $student,
            'attendance'   => $this->attendanceSnapshot($studentId),
            'latestResult' => $this->latestResultSnapshot($studentId, $classId),
            'fees'         => $this->feeSnapshot($studentId),
            'books'        => $this->bookSnapshot($studentId),
            'notices'      => $this->recentNotices(),
        ]);
    }

    /**
     * Overall attendance counts and percentage (late counts as attended).
     */
    private function attendanceSnapshot(int $studentId): array
    {
        $records = Attendance::where('user_id', $studentId)->whereHas('session')->get();

        $total   = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent  = $records->where('status', 'absent')->count();
        $late    = $records->where('status', 'late')->count();
        $percentage = $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0;

        return compact('total', 'present', 'absent', 'late', 'percentage');
    }

    /**
     * Summary of the most recent published exam result.
     */
    private function latestResultSnapshot(int $studentId, ?int $classId): ?array
    {
        $results = ExamResult::where('student_id', $studentId)
            ->whereHas('exam', fn ($q) => $q->where('is_published', true))
            ->with('exam')
            ->get();

        if ($results->isEmpty()) {
            return null;
        }

        // Pick the latest exam by start date.
        $examId = $results
            ->sortByDesc(fn ($r) => $r->exam->start_date)
            ->first()->exam_id;

        $examResults = $results->where('exam_id', $examId);
        $exam = $examResults->first()->exam;

        $schedules = ExamSchedule::where('exam_id', $examId)
            ->when($classId, fn ($q) => $q->where('class_id', $classId))
            ->get()
            ->keyBy('subject_id');

        $totalObtained = 0;
        $totalMax = 0;
        foreach ($examResults as $result) {
            $max = (float) ($schedules->get($result->subject_id)?->max_marks ?? 100);
            $totalObtained += (float) $result->marks_obtained;
            $totalMax += $max;
        }

        $percentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 1) : 0;

        return [
            'exam_id'    => $examId,
            'exam_name'  => $exam->name,
            'percentage' => $percentage,
            'grade'      => $this->calcGrade($totalObtained, $totalMax),
        ];
    }

    /**
     * Fee outstanding balance and overdue count.
     */
    private function feeSnapshot(int $studentId): array
    {
        $fees = Fee::where('student_id', $studentId)
            ->where('status', '!=', 'cancelled')
            ->with('payments')
            ->get();

        $today = Carbon::today();
        $outstanding = 0;
        $overdue = 0;

        foreach ($fees as $fee) {
            $net = (float) $fee->amount - (float) $fee->discount;
            $paid = (float) $fee->payments->sum('amount');
            $balance = round($net - $paid, 2);
            $outstanding += $balance;

            if ($balance > 0 && $fee->due_date && Carbon::parse($fee->due_date)->isPast()) {
                $overdue++;
            }
        }

        return [
            'outstanding' => round($outstanding, 2),
            'overdue'     => $overdue,
        ];
    }

    /**
     * Currently issued / overdue book counts.
     */
    private function bookSnapshot(int $studentId): array
    {
        $issues = BookIssue::where('user_id', $studentId)->get();
        $today = Carbon::today();

        $active = $issues->where('status', 'issued')->count();
        $overdue = $issues
            ->where('status', 'issued')
            ->filter(fn ($i) => $i->due_date && $today->gt(Carbon::parse($i->due_date)))
            ->count();

        return compact('active', 'overdue');
    }

    /**
     * Recent notices visible to students.
     */
    private function recentNotices()
    {
        $today = Carbon::today()->format('Y-m-d');

        return Notice::where('is_published', true)
            ->where(function ($q) use ($today) {
                $q->whereNull('start_date')->orWhereDate('start_date', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', $today);
            })
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->take(5)
            ->get()
            ->filter(function (Notice $notice) {
                $roles = $notice->target_roles;
                return empty($roles) || in_array('student', $roles, true);
            })
            ->values();
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
