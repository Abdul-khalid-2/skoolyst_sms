<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\ScopesTeacherAssignments;
use App\Models\Classes;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    use ScopesTeacherAssignments;

    public function index(Request $request): View
    {
        $teacher     = auth()->user();
        $taughtPairs = $this->allowedPairs();
        $allowedClassIds = $this->allowedClassIds();

        $classes = Classes::with('sections')
            ->whereIn('id', $allowedClassIds)
            ->orderBy('numeric_value')
            ->get();

        $selectedClassId   = $request->integer('class_id') ?: null;
        $selectedSectionId = $request->integer('section_id') ?: null;
        $students          = collect();

        if ($allowedClassIds->isNotEmpty()) {
            $query = StudentProfile::with(['student', 'student.parents', 'class', 'section'])
                ->whereHas('student', fn ($q) => $q->where('role', 'student'))
                ->where(function ($outer) use ($taughtPairs) {
                    foreach ($taughtPairs as $pair) {
                        $outer->orWhere(function ($q) use ($pair) {
                            $q->where('class_id', $pair['class_id'])
                                ->where('section_id', $pair['section_id']);
                        });
                    }
                });

            if ($selectedClassId && $allowedClassIds->contains($selectedClassId)) {
                $query->where('class_id', $selectedClassId);
            }

            if ($selectedSectionId) {
                $query->where('section_id', $selectedSectionId);
            }

            $students = $query->get()
                ->sortBy(fn ($s) => [
                    optional($s->class)->numeric_value,
                    optional($s->section)->name,
                    optional($s->student)->name,
                ])
                ->values();
        }

        $stats = [
            'students' => $students->count(),
            'classes'  => $students->pluck('class_id')->filter()->unique()->count(),
            'sections' => $students->pluck('section_id')->filter()->unique()->count(),
        ];

        return view('app.teacher.students.index', [
            'teacher'           => $teacher,
            'students'          => $students,
            'classes'           => $classes,
            'stats'             => $stats,
            'selectedClassId'   => $selectedClassId,
            'selectedSectionId' => $selectedSectionId,
        ]);
    }
}
