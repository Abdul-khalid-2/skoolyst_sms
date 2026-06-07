<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\BookIssue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookIssueController extends Controller
{
    public function index(): View
    {
        $parent = auth()->user();
        $children = $parent->children()->orderBy('name')->get();
        $childIds = $children->pluck('id');

        $finePerDay = (float) (DB::table('settings')->value('late_fine_per_day') ?? 50);
        $today = Carbon::today();

        $issues = BookIssue::whereIn('user_id', $childIds)
            ->with(['book', 'user'])
            ->orderByDesc('issue_date')
            ->get()
            ->map(function (BookIssue $issue) use ($today, $finePerDay) {
                $due = $issue->due_date ? Carbon::parse($issue->due_date) : null;
                $isActive = $issue->status === 'issued';
                $isOverdue = $isActive && $due && $today->gt($due);
                $daysOverdue = $isOverdue ? $today->diffInDays($due) : 0;
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

        return view('app.parent.books.index', compact('parent', 'children', 'issues', 'summary'));
    }
}
