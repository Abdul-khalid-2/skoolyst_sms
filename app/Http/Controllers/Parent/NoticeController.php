<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(): View
    {
        $parent = auth()->user();
        $today = Carbon::today()->format('Y-m-d');
        $branchId = $parent->branch_id;

        $notices = Notice::where('is_published', true)
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->where(function ($q) use ($today) {
                $q->whereNull('start_date')->orWhereDate('start_date', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', $today);
            })
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->get()
            ->filter(function (Notice $notice) {
                $roles = $notice->target_roles;

                return empty($roles) || in_array('parent', $roles, true);
            })
            ->values();

        return view('app.parent.notices.index', compact('parent', 'notices'));
    }
}
