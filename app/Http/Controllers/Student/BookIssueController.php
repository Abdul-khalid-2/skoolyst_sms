<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookIssue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookIssueController extends Controller
{
    /**
     * Display the authenticated student's book issue history.
     */
    public function index(): View
    {
        $student = auth()->user();
        $finePerDay = (float) (DB::table('settings')->value('late_fine_per_day') ?? 50);
        $today = Carbon::today();

        $issues = BookIssue::where('user_id', $student->id)
            ->with('book')
            ->orderByDesc('issue_date')
            ->get()
            ->map(function (BookIssue $issue) use ($today, $finePerDay) {
                $due = $issue->due_date ? Carbon::parse($issue->due_date) : null;
                $isActive = $issue->status === 'issued';

                // Overdue applies only to books still on loan past the due date.
                $isOverdue = $isActive && $due && $today->gt($due);
                $daysOverdue = $isOverdue ? $today->diffInDays($due) : 0;

                // Accruing (estimated) fine for active overdue loans; otherwise the recorded fine.
                $estimatedFine = $isOverdue
                    ? round($daysOverdue * $finePerDay, 2)
                    : (float) $issue->fine_amount;

                $issue->is_overdue = $isOverdue;
                $issue->days_overdue = $daysOverdue;
                $issue->display_fine = $estimatedFine;

                return $issue;
            });

        $summary = [
            'active'   => $issues->where('status', 'issued')->count(),
            'overdue'  => $issues->where('is_overdue', true)->count(),
            'returned' => $issues->where('status', 'returned')->count(),
            'fine_due' => round($issues->where('status', 'issued')->sum('display_fine'), 2),
        ];

        return view('app.student.books.index', compact('student', 'issues', 'summary'));
    }
}
