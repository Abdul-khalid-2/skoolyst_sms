<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\BookIssue;
use App\Models\Fee;
use App\Services\Notice\NoticeAudienceService;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(NoticeAudienceService $noticeAudience): View
    {
        $parent = auth()->user();
        $children = $parent->children()
            ->with(['studentProfile.class', 'studentProfile.section'])
            ->get();

        $childIds = $children->pluck('id');

        return view('app.parent.dashboard', [
            'parent'   => $parent,
            'children' => $children,
            'stats'    => [
                'children_count' => $children->count(),
                'attendance'     => $this->attendanceSnapshot($childIds),
                'fees'           => $this->feeSnapshot($childIds),
                'books'          => $this->bookSnapshot($childIds),
            ],
            'notices' => $noticeAudience->forUser($parent, 5),
        ]);
    }

    private function attendanceSnapshot($childIds): array
    {
        if ($childIds->isEmpty()) {
            return ['total' => 0, 'present' => 0, 'absent' => 0, 'late' => 0, 'percentage' => 0];
        }

        $records = Attendance::whereIn('user_id', $childIds)->whereHas('session')->get();
        $total   = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent  = $records->where('status', 'absent')->count();
        $late    = $records->where('status', 'late')->count();
        $percentage = $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0;

        return compact('total', 'present', 'absent', 'late', 'percentage');
    }

    private function feeSnapshot($childIds): array
    {
        if ($childIds->isEmpty()) {
            return ['outstanding' => 0, 'overdue' => 0];
        }

        $fees = Fee::whereIn('student_id', $childIds)
            ->where('status', '!=', 'cancelled')
            ->with('payments')
            ->get();

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

    private function bookSnapshot($childIds): array
    {
        if ($childIds->isEmpty()) {
            return ['active' => 0, 'overdue' => 0];
        }

        $issues = BookIssue::whereIn('user_id', $childIds)->get();
        $today = Carbon::today();

        $active = $issues->where('status', 'issued')->count();
        $overdue = $issues
            ->where('status', 'issued')
            ->filter(fn ($i) => $i->due_date && $today->gt(Carbon::parse($i->due_date)))
            ->count();

        return compact('active', 'overdue');
    }
}
