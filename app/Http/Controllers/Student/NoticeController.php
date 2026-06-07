<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today()->format('Y-m-d');

        $notices = Notice::where('is_published', true)
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

                return empty($roles) || in_array('student', $roles, true);
            })
            ->values();

        return view('app.student.notices.index', compact('notices'));
    }
}
