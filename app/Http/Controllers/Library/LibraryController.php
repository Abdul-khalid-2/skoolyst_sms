<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index()
    {
        $branchId = $this->branchId();
        $today    = now()->format('Y-m-d');

        $totalBooks     = Book::where('branch_id', $branchId)->sum('quantity');
        $availableBooks = Book::where('branch_id', $branchId)->sum('available');
        $issuedBooks    = BookIssue::where('branch_id', $branchId)->where('status', 'issued')->count();
        $overdueBooks   = BookIssue::where('branch_id', $branchId)
            ->where('status', 'issued')
            ->whereDate('due_date', '<', $today)
            ->count();

        $recentIssues = BookIssue::where('branch_id', $branchId)
            ->with(['book', 'user'])
            ->orderByDesc('issue_date')
            ->limit(8)
            ->get();

        $byCategory = Book::where('branch_id', $branchId)
            ->select('category',
                DB::raw('COUNT(*) as titles'),
                DB::raw('SUM(quantity) as total'),
                DB::raw('SUM(available) as available'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('app.library.index', compact(
            'totalBooks', 'availableBooks', 'issuedBooks', 'overdueBooks',
            'recentIssues', 'byCategory'
        ));
    }
}
