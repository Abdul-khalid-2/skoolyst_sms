<?php

namespace App\Http\Controllers\Teacher\Concerns;

use App\Models\Classes;
use App\Models\Section;
use App\Models\TimeTable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait ScopesTeacherAssignments
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id;
    }

    /**
     * (class_id, section_id) combinations the authenticated teacher may access.
     */
    private function allowedPairs(): Collection
    {
        $teacher = Auth::user();

        $pairs = TimeTable::where('teacher_id', $teacher->id)
            ->whereNotNull('class_id')
            ->whereNotNull('section_id')
            ->select('class_id', 'section_id')
            ->distinct()
            ->get()
            ->map(fn ($row) => [
                'class_id'   => (int) $row->class_id,
                'section_id' => (int) $row->section_id,
            ]);

        $classTeacherOfId = optional($teacher->teacherProfile)->class_teacher_of;

        if ($classTeacherOfId) {
            Section::where('class_id', $classTeacherOfId)
                ->pluck('id')
                ->each(function ($sectionId) use (&$pairs, $classTeacherOfId) {
                    $pairs->push([
                        'class_id'   => (int) $classTeacherOfId,
                        'section_id' => (int) $sectionId,
                    ]);
                });
        }

        return $pairs->unique(fn ($p) => $p['class_id'].'-'.$p['section_id'])->values();
    }

    private function allowedClassIds(): Collection
    {
        $pairs = $this->allowedPairs();

        $classTeacherOfId = optional(Auth::user()->teacherProfile)->class_teacher_of;

        return $pairs->pluck('class_id')
            ->push($classTeacherOfId)
            ->filter()
            ->unique()
            ->values();
    }

    private function allows(int $classId, ?int $sectionId = null): bool
    {
        if ($sectionId === null) {
            return $this->allowedClassIds()->contains($classId);
        }

        return $this->allowedPairs()
            ->contains(fn ($p) => $p['class_id'] === $classId && $p['section_id'] === $sectionId);
    }

    /**
     * Subject ids the teacher may enter marks for in the given class:
     * the class's curriculum (class_subject pivot) INTERSECTED with the
     * subjects assigned to this teacher (teacher_subjects). So a teacher only
     * marks their own subjects, and only those the class actually offers.
     */
    private function allowedSubjectIdsForClass(int $classId): Collection
    {
        $class = Classes::find($classId);

        if (! $class) {
            return collect();
        }

        $curriculum      = $class->subjects->pluck('id');
        $teacherSubjects = Auth::user()->teacherSubjects->pluck('id');

        return $curriculum->intersect($teacherSubjects)->unique()->values();
    }

    private function allowsSubject(int $classId, int $subjectId): bool
    {
        return $this->allowedSubjectIdsForClass($classId)->contains($subjectId);
    }
}
