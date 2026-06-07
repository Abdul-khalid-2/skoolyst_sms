<?php

namespace App\Http\Controllers\Teacher\Concerns;

use App\Services\Academic\AssignmentService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait ScopesTeacherAssignments
{
    private function branchId(): ?int
    {
        return Auth::user()?->branch_id;
    }

    private function assignmentService(): AssignmentService
    {
        return app(AssignmentService::class);
    }

    /**
     * (class_id, section_id) combinations the authenticated teacher may access.
     */
    private function allowedPairs(): Collection
    {
        return $this->assignmentService()->getTeacherClassSectionPairs(Auth::user());
    }

    private function allowedClassIds(): Collection
    {
        return $this->allowedPairs()->pluck('class_id')->unique()->values();
    }

    private function allows(int $classId, ?int $sectionId = null): bool
    {
        return $this->assignmentService()->teacherAllowsClassSection(Auth::user(), $classId, $sectionId);
    }

    private function allowedSubjectIdsForClass(int $classId): Collection
    {
        return $this->assignmentService()->getTeacherSubjectIdsForClass(Auth::user(), $classId);
    }

    private function allowsSubject(int $classId, int $subjectId): bool
    {
        return $this->assignmentService()->teacherAllowsSubject(Auth::user(), $classId, $subjectId);
    }

    private function allowedSubjectIds(): Collection
    {
        return $this->assignmentService()
            ->getTeacherScope(Auth::user())
            ->pluck('subject_id')
            ->unique()
            ->values();
    }
}
