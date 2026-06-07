<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('subjects')) {
            Schema::table('subjects', function (Blueprint $table) {
                if (Schema::hasColumn('subjects', 'section_id')) {
                    $table->dropConstrainedForeignId('section_id');
                }
                if (Schema::hasColumn('subjects', 'class_id')) {
                    $table->dropConstrainedForeignId('class_id');
                }
            });
        }

        if (Schema::hasTable('classes') && Schema::hasColumn('classes', 'teacher_id')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropConstrainedForeignId('teacher_id');
            });
        }

        if (Schema::hasTable('teacher_profiles') && Schema::hasColumn('teacher_profiles', 'is_class_teacher')) {
            Schema::table('teacher_profiles', function (Blueprint $table) {
                $table->dropColumn('is_class_teacher');
            });
        }

        if (Schema::hasTable('teacher_subjects')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $this->dropForeignIfExists('teacher_subjects', 'class_id');
            $this->dropIndexIfExists('teacher_subjects', 'teacher_subjects_teacher_id_subject_id_class_id_unique');

            if (Schema::hasColumn('teacher_subjects', 'class_id')) {
                Schema::table('teacher_subjects', function (Blueprint $table) {
                    $table->dropColumn('class_id');
                });
            }

            if (Schema::hasColumn('teacher_subjects', 'is_class_teacher')) {
                Schema::table('teacher_subjects', function (Blueprint $table) {
                    $table->dropColumn('is_class_teacher');
                });
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $this->addUniqueIfMissing('teacher_subjects', 'teacher_subjects_teacher_id_subject_id_unique', ['teacher_id', 'subject_id']);
        }

        if (Schema::hasTable('section_subject_teacher') && Schema::hasColumn('section_subject_teacher', 'class_id')) {
            Schema::table('section_subject_teacher', function (Blueprint $table) {
                $table->dropConstrainedForeignId('class_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('subjects')) {
            Schema::table('subjects', function (Blueprint $table) {
                if (! Schema::hasColumn('subjects', 'class_id')) {
                    $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
                }
                if (! Schema::hasColumn('subjects', 'section_id')) {
                    $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('classes') && ! Schema::hasColumn('classes', 'teacher_id')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            });
        }

        if (Schema::hasTable('teacher_profiles') && ! Schema::hasColumn('teacher_profiles', 'is_class_teacher')) {
            Schema::table('teacher_profiles', function (Blueprint $table) {
                $table->boolean('is_class_teacher')->default(false);
            });
        }

        if (Schema::hasTable('teacher_subjects')) {
            Schema::table('teacher_subjects', function (Blueprint $table) {
                if (! Schema::hasColumn('teacher_subjects', 'class_id')) {
                    $table->foreignId('class_id')->nullable()->constrained()->nullOnDelete();
                }
                if (! Schema::hasColumn('teacher_subjects', 'is_class_teacher')) {
                    $table->boolean('is_class_teacher')->default(false);
                }
            });
        }

        if (Schema::hasTable('section_subject_teacher') && ! Schema::hasColumn('section_subject_teacher', 'class_id')) {
            Schema::table('section_subject_teacher', function (Blueprint $table) {
                $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            });
        }
    }

    private function dropForeignIfExists(string $table, string $column): void
    {
        if (! Schema::hasColumn($table, $column)) {
            return;
        }

        $db = DB::getDatabaseName();
        $fk = DB::selectOne(
            'SELECT constraint_name FROM information_schema.key_column_usage WHERE table_schema = ? AND table_name = ? AND column_name = ? AND referenced_table_name IS NOT NULL LIMIT 1',
            [$db, $table, $column]
        );

        if ($fk) {
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$fk->constraint_name}`");
        }
    }

    private function dropIndexIfExists(string $table, string $indexName): void
    {
        $db = DB::getDatabaseName();
        $index = DB::selectOne(
            'SELECT index_name FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ? LIMIT 1',
            [$db, $table, $indexName]
        );

        if ($index) {
            DB::statement("ALTER TABLE `{$table}` DROP INDEX `{$indexName}`");
        }
    }

    private function addUniqueIfMissing(string $table, string $indexName, array $columns): void
    {
        $db = DB::getDatabaseName();
        $index = DB::selectOne(
            'SELECT index_name FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ? LIMIT 1',
            [$db, $table, $indexName]
        );

        if (! $index) {
            Schema::table($table, function (Blueprint $table) use ($columns) {
                $table->unique($columns);
            });
        }
    }
};
