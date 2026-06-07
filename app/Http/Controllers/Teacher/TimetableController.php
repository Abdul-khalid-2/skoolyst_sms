<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use Illuminate\View\View;

class TimetableController extends Controller
{
    public function index(): View
    {
        $teacher = auth()->user();
        $branchId = $teacher->branch_id;

        $entries = TimeTable::with(['subject', 'class', 'section'])
            ->where('teacher_id', $teacher->id)
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return view('app.teacher.timetable.index', compact('teacher', 'entries'));
    }
}
