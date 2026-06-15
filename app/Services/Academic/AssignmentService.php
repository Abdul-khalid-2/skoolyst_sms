<?php

namespace App\Services\Academic;

use App\Models\Classes;
use App\Models\Section;
use App\Models\SectionSubjectTeacher;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class AssignmentService
{
    public function assignClassCurriculum(Classes $class, array $subjectIds): void
    {
        $sync = [];
        foreach ($subjectIds as $subjectId) {
            $sync[$subjectId] = ['branch_id' => $class->branch_id];
        }

        $class->subjects()->sync($sync);
    }

    public function assignTeacherCapabilities(User $teacher, array $subjectIds): void
    {
        $sync = [];
        foreach ($subjectIds as $subjectId) {
            $sync[$subjectId] = ['branch_id' => $teacher->branch_id];
        }

        $teacher->teacherSubjects()->sync($sync);
    }

    /**
     * @param  array<int, int|null>  $subjectTeacherMap  subject_id => teacher_id
     */
    public function assignSectionTeachers(Section $section, array $subjectTeacherMap): void
    {
        $class = $section->class ?? Classes::find($section->class_id);

        foreach ($subjectTeacherMap as $subjectId => $teacherId) {
            if ($teacherId) {
                SectionSubjectTeacher::updateOrCreate(
                    ['section_id' => $section->id, 'subject_id' => $subjectId],
                    [
                        'teacher_id' => $teacherId,
                        'branch_id'  => $section->branch_id ?? $class?->branch_id,
                    ]
                );
            } else {
                SectionSubjectTeacher::where('section_id', $section->id)
                    ->where('subject_id', $subjectId)
                    ->delete();
            }
        }
    }

    public function assignClassTeacher(?User $teacher, ?Classes $class): void
    {
        if ($class) {
            TeacherProfile::where('class_teacher_of', $class->id)
                ->update(['class_teacher_of' => null]);
        }

        if ($teacher) {
            TeacherProfile::where('teacher_id', $teacher->id)
                ->update(['class_teacher_of' => null]);
        }

        if ($teacher && $class) {
            TeacherProfile::where('teacher_id', $teacher->id)
                ->update(['class_teacher_of' => $class->id]);
        }
    }

    /**
     * @return Collection<int, array{class_id: int, section_id: int, subject_id: int}>
     */
    public function getTeacherScope(User $teacher): Collection
    {
        $scope = SectionSubjectTeacher::where('teacher_id', $teacher->id)
            ->get(['section_id', 'subject_id'])
            ->map(function (SectionSubjectTeacher $row) {
                $section = Section::find($row->section_id);

                return [
                    'class_id'   => (int) $section?->class_id,
                    'section_id' => (int) $row->section_id,
                    'subject_id' => (int) $row->subject_id,
                ];
            })
            ->filter(fn ($t) => $t['class_id'] > 0);

        $classTeacherOfId = optional($teacher->teacherProfile)->class_teacher_of;

        if ($classTeacherOfId) {
            $class = Classes::with(['sections', 'subjects'])->find($classTeacherOfId);

            if ($class) {
                foreach ($class->sections as $section) {
                    foreach ($class->subjects as $subject) {
                        $scope->push([
                            'class_id'   => (int) $class->id,
                            'section_id' => (int) $section->id,
                            'subject_id' => (int) $subject->id,
                        ]);
                    }
                }
            }
        }

        return $scope->unique(fn ($t) => "{$t['class_id']}-{$t['section_id']}-{$t['subject_id']}")->values();
    }

    public function getTeacherClassSectionPairs(User $teacher): Collection
    {
        return $this->getTeacherScope($teacher)
            ->map(fn ($t) => ['class_id' => $t['class_id'], 'section_id' => $t['section_id']])
            ->unique(fn ($p) => "{$p['class_id']}-{$p['section_id']}")
            ->values();
    }

    public function getTeacherSubjectIdsForClass(User $teacher, int $classId): Collection
    {
        return $this->getTeacherScope($teacher)
            ->where('class_id', $classId)
            ->pluck('subject_id')
            ->unique()
            ->values();
    }

    public function teacherAllowsClassSection(User $teacher, int $classId, ?int $sectionId = null): bool
    {
        $pairs = $this->getTeacherClassSectionPairs($teacher);

        if ($sectionId === null) {
            return $pairs->pluck('class_id')->contains($classId);
        }

        return $pairs->contains(fn ($p) => $p['class_id'] === $classId && $p['section_id'] === $sectionId);
    }

    public function teacherAllowsSubject(User $teacher, int $classId, int $subjectId): bool
    {
        return $this->getTeacherSubjectIdsForClass($teacher, $classId)->contains($subjectId);
    }

    public function ensureSectionAllocation(int $sectionId, int $subjectId, int $teacherId): void
    {
        $section = Section::findOrFail($sectionId);

        SectionSubjectTeacher::updateOrCreate(
            ['section_id' => $sectionId, 'subject_id' => $subjectId],
            [
                'teacher_id' => $teacherId,
                'branch_id'  => $section->branch_id,
            ]
        );
    }

    public function teacherHasCapability(int $teacherId, int $subjectId): bool
    {
        return User::where('id', $teacherId)
            ->whereHas('teacherSubjects', fn ($q) => $q->where('subjects.id', $subjectId))
            ->exists();
    }

    public function getAllocatedTeachersForSectionSubject(int $sectionId, int $subjectId, ?int $branchId = null): Collection
    {
        $teacherIds = SectionSubjectTeacher::where('section_id', $sectionId)
            ->where('subject_id', $subjectId)
            ->pluck('teacher_id');

        if ($teacherIds->isEmpty()) {
            return $this->getEligibleTeachersForSubject($subjectId, $branchId);
        }

        $query = User::whereIn('id', $teacherIds)->orderBy('name');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        return $query->get(['id', 'name']);
    }

    public function ensureClassCurriculumIncludes(Classes $class, int $subjectId): void
    {
        if ($class->subjects()->where('subjects.id', $subjectId)->exists()) {
            return;
        }

        $class->subjects()->syncWithoutDetaching([
            $subjectId => ['branch_id' => $class->branch_id],
        ]);
    }

    public function validateTimetableSlot(int $classId, int $sectionId, int $subjectId, int $teacherId): void
    {
        $class = Classes::with('subjects')->find($classId);

        if ($class && ! $class->subjects->pluck('id')->contains($subjectId)) {
            if ($this->teacherHasCapability($teacherId, $subjectId)) {
                $this->ensureClassCurriculumIncludes($class, $subjectId);
                $class->load('subjects');
            } else {
                throw ValidationException::withMessages([
                    'subject_id' => ['This subject is not part of the class curriculum. Add it under Academic Assignments → Class Curriculum first.'],
                ]);
            }
        }

        $allocated = SectionSubjectTeacher::where('section_id', $sectionId)
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->exists();

        if ($allocated) {
            return;
        }

        $existingAllocation = SectionSubjectTeacher::where('section_id', $sectionId)
            ->where('subject_id', $subjectId)
            ->exists();

        if (! $existingAllocation && $this->teacherHasCapability($teacherId, $subjectId)) {
            $this->ensureSectionAllocation($sectionId, $subjectId, $teacherId);

            return;
        }

        throw ValidationException::withMessages([
            'teacher_id' => ['Selected teacher is not allocated to teach this subject in this section. Assign them first in Section Teacher Allocation.'],
        ]);
    }

    /**
     * Teachers eligible for a subject (capability list).
     */
    public function getEligibleTeachersForSubject(int $subjectId, ?int $branchId = null): Collection
    {
        $query = User::role('teacher')
            ->whereHas('teacherSubjects', fn ($q) => $q->where('subjects.id', $subjectId))
            ->with('teacherProfile:id,teacher_id,employee_id');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        return $query->orderBy('name')->get(['id', 'name']);
    }
}
