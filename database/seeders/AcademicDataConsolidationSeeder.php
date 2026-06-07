<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AcademicDataConsolidationSeeder extends Seeder
{
    public function run(): void
    {
        $this->backfillClassSubjectFromSubjects();
        $this->backfillClassSubjectFromTimetable();
        $this->syncClassTeacherFromClasses();
        $this->backfillSectionSubjectTeacherFromTimetable();
        $this->backfillBranchIdsOnPivots();
    }

    /**
     * Copy subjects.class_id into class_subject pivot where missing.
     */
    private function backfillClassSubjectFromSubjects(): void
    {
        if (! Schema::hasTable('subjects') || ! Schema::hasColumn('subjects', 'class_id')) {
            return;
        }

        $subjects = DB::table('subjects')
            ->whereNotNull('class_id')
            ->whereNull('deleted_at')
            ->get(['id', 'class_id', 'branch_id']);

        foreach ($subjects as $subject) {
            $exists = DB::table('class_subject')
                ->where('class_id', $subject->class_id)
                ->where('subject_id', $subject->id)
                ->exists();

            if (! $exists) {
                DB::table('class_subject')->insert([
                    'class_id'   => $subject->class_id,
                    'subject_id' => $subject->id,
                    'branch_id'  => $subject->branch_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Ensure class_subject includes every subject used in existing timetables.
     */
    private function backfillClassSubjectFromTimetable(): void
    {
        if (! Schema::hasTable('time_tables') || ! Schema::hasTable('class_subject')) {
            return;
        }

        $slots = DB::table('time_tables')
            ->whereNull('deleted_at')
            ->whereNotNull('subject_id')
            ->whereNotNull('class_id')
            ->select('class_id', 'subject_id', 'branch_id')
            ->distinct()
            ->get();

        foreach ($slots as $slot) {
            $exists = DB::table('class_subject')
                ->where('class_id', $slot->class_id)
                ->where('subject_id', $slot->subject_id)
                ->exists();

            if ($exists) {
                continue;
            }

            $branchId = $slot->branch_id
                ?? DB::table('classes')->where('id', $slot->class_id)->value('branch_id');

            DB::table('class_subject')->insert([
                'class_id'   => $slot->class_id,
                'subject_id' => $slot->subject_id,
                'branch_id'  => $branchId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Ensure teacher_profiles.class_teacher_of matches classes.teacher_id.
     */
    private function syncClassTeacherFromClasses(): void
    {
        if (! Schema::hasTable('classes') || ! Schema::hasColumn('classes', 'teacher_id')) {
            return;
        }

        $classes = DB::table('classes')
            ->whereNotNull('teacher_id')
            ->whereNull('deleted_at')
            ->get(['id', 'teacher_id', 'branch_id']);

        foreach ($classes as $class) {
            $profile = DB::table('teacher_profiles')
                ->where('teacher_id', $class->teacher_id)
                ->first();

            if ($profile) {
                $update = [
                    'class_teacher_of' => $class->id,
                    'updated_at'       => now(),
                ];

                if (Schema::hasColumn('teacher_profiles', 'is_class_teacher')) {
                    $update['is_class_teacher'] = true;
                }

                DB::table('teacher_profiles')
                    ->where('id', $profile->id)
                    ->update($update);
            }
        }
    }

    /**
     * Create section_subject_teacher rows from timetable entries where missing.
     */
    private function backfillSectionSubjectTeacherFromTimetable(): void
    {
        if (! Schema::hasTable('time_tables')) {
            return;
        }

        $slots = DB::table('time_tables')
            ->whereNull('deleted_at')
            ->whereNotNull('teacher_id')
            ->whereNotNull('subject_id')
            ->whereNotNull('section_id')
            ->whereNotNull('class_id')
            ->select('class_id', 'section_id', 'subject_id', 'teacher_id', 'branch_id')
            ->distinct()
            ->get();

        foreach ($slots as $slot) {
            $exists = DB::table('section_subject_teacher')
                ->where('section_id', $slot->section_id)
                ->where('subject_id', $slot->subject_id)
                ->exists();

            if (! $exists) {
                DB::table('section_subject_teacher')->insert([
                    'section_id' => $slot->section_id,
                    'subject_id' => $slot->subject_id,
                    'teacher_id' => $slot->teacher_id,
                    'branch_id'  => $slot->branch_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Populate branch_id on pivot tables from related entities.
     */
    private function backfillBranchIdsOnPivots(): void
    {
        if (Schema::hasTable('class_subject') && Schema::hasColumn('class_subject', 'branch_id')) {
            foreach (DB::table('class_subject')->whereNull('branch_id')->orderBy('id')->get() as $row) {
                $branchId = DB::table('classes')->where('id', $row->class_id)->value('branch_id');
                if ($branchId) {
                    DB::table('class_subject')->where('id', $row->id)->update(['branch_id' => $branchId]);
                }
            }
        }

        if (Schema::hasTable('teacher_subjects') && Schema::hasColumn('teacher_subjects', 'branch_id')) {
            foreach (DB::table('teacher_subjects')->whereNull('branch_id')->orderBy('id')->get() as $row) {
                $branchId = DB::table('users')->where('id', $row->teacher_id)->value('branch_id');
                if ($branchId) {
                    DB::table('teacher_subjects')->where('id', $row->id)->update(['branch_id' => $branchId]);
                }
            }
        }

        if (Schema::hasTable('section_subject_teacher') && Schema::hasColumn('section_subject_teacher', 'branch_id')) {
            foreach (DB::table('section_subject_teacher')->whereNull('branch_id')->orderBy('id')->get() as $row) {
                $branchId = DB::table('sections')->where('id', $row->section_id)->value('branch_id');
                if ($branchId) {
                    DB::table('section_subject_teacher')->where('id', $row->id)->update(['branch_id' => $branchId]);
                }
            }
        }
    }
}
