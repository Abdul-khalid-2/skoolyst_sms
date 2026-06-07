<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(): View
    {
        $teacher = auth()->user()->load([
            'subjectAllocations.subject',
            'subjectAllocations.section.class',
            'teacherProfile.classTeacherOf.subjects',
        ]);

        $allocations = $teacher->subjectAllocations->sortBy([
            fn ($a) => optional($a->section?->class)->numeric_value,
            fn ($a) => optional($a->section)->name,
            fn ($a) => optional($a->subject)->name,
        ]);

        return view('app.teacher.subjects.index', compact('teacher', 'allocations'));
    }
}
