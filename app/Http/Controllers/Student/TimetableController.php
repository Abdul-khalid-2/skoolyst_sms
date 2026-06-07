<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use Illuminate\View\View;

class TimetableController extends Controller
{
    public function index(): View
    {
        $student = auth()->user()->load(['studentProfile.class', 'studentProfile.section']);
        $profile = $student->studentProfile;

        $entries = collect();
        if ($profile?->class_id && $profile?->section_id) {
            $entries = TimeTable::with(['subject', 'teacher', 'class', 'section'])
                ->where('class_id', $profile->class_id)
                ->where('section_id', $profile->section_id)
                ->when($student->branch_id, fn ($q) => $q->where('branch_id', $student->branch_id))
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get()
                ->groupBy('day_of_week');
        }

        return view('app.student.timetable.index', compact('student', 'profile', 'entries'));
    }
}
