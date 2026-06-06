<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\StudentProfile;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * List students belonging to the classes/sections the authenticated
     * teacher teaches, plus the class they are class-teacher of.
     */
    public function index(Request $request): View
    {
        $teacher = auth()->user();

        // (class_id, section_id) combinations the teacher teaches via timetable.
        $taughtPairs = TimeTable::where('teacher_id', $teacher->id)
            ->whereNotNull('class_id')
            ->select('class_id', 'section_id')
            ->distinct()
            ->get();

        // The whole class this teacher is the class-teacher of (all sections).
        $classTeacherOfId = optional($teacher->teacherProfile)->class_teacher_of;

        // Allowed class ids drive the filter dropdown and the access boundary.
        $allowedClassIds = $taughtPairs->pluck('class_id')
            ->push($classTeacherOfId)
            ->filter()
            ->unique()
            ->values();

        $classes = Classes::with('sections')
            ->whereIn('id', $allowedClassIds)
            ->orderBy('numeric_value')
            ->get();

        $selectedClassId   = $request->integer('class_id') ?: null;
        $selectedSectionId = $request->integer('section_id') ?: null;

        $students = collect();

        if ($allowedClassIds->isNotEmpty()) {
            $query = StudentProfile::with(['student', 'student.parents', 'class', 'section'])
                ->whereHas('student', fn ($q) => $q->where('role', 'student'))
                ->where(function ($outer) use ($taughtPairs, $classTeacherOfId) {
                    foreach ($taughtPairs as $pair) {
                        $outer->orWhere(function ($q) use ($pair) {
                            $q->where('class_id', $pair->class_id);
                            if ($pair->section_id) {
                                $q->where('section_id', $pair->section_id);
                            }
                        });
                    }

                    if ($classTeacherOfId) {
                        $outer->orWhere('class_id', $classTeacherOfId);
                    }
                });

            // Optional UI filters, constrained to what the teacher may see.
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
