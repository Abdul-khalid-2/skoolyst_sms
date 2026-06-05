<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamSchedule;
use App\Models\StudentProfile;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ExamsSeeder extends Seeder
{
    public function run(): void
    {
        if (Exam::count() > 0) {
            $this->command->info('Exams already seeded. Skipping.');
            return;
        }

        $branchId = Branch::query()->value('id') ?? 1;
        $classes  = Classes::where('branch_id', $branchId)->orderBy('numeric_value')->get();
        $subjects = Subject::orderBy('name')->get();

        if ($classes->isEmpty() || $subjects->isEmpty()) {
            $this->command->warn('No classes or subjects found — skipping exam seeder.');
            return;
        }

        // ── 1. Define Exams ───────────────────────────────────────────────────────
        $examDefs = [
            [
                'name'         => '1st Term Examination 2026',
                'description'  => 'First term assessment covering January to March syllabus.',
                'start_date'   => '2026-03-01',
                'end_date'     => '2026-03-14',
                'is_published' => true,
                'completed'    => true,
            ],
            [
                'name'         => 'Mid-Term Examination 2026',
                'description'  => 'Mid-year examination covering April to June syllabus.',
                'start_date'   => '2026-06-10',
                'end_date'     => '2026-06-23',
                'is_published' => true,
                'completed'    => false,
            ],
            [
                'name'         => 'Annual Examination 2026',
                'description'  => 'Final annual examination for session 2025–2026.',
                'start_date'   => '2026-11-01',
                'end_date'     => '2026-11-20',
                'is_published' => false,
                'completed'    => false,
            ],
        ];

        $exams         = [];
        $scheduleCount = 0;
        $resultCount   = 0;

        // Time slots cycling per subject index
        $timeSlots = [
            ['08:00', '10:00'],
            ['10:30', '12:30'],
            ['08:00', '10:00'],
            ['10:30', '12:30'],
            ['08:00', '10:00'],
        ];
        $rooms = ['Room 101', 'Room 102', 'Room 103', 'Hall A', 'Hall B', 'Room 201'];

        foreach ($examDefs as $def) {
            $exam = Exam::create([
                'branch_id'    => $branchId,
                'name'         => $def['name'],
                'description'  => $def['description'],
                'start_date'   => $def['start_date'],
                'end_date'     => $def['end_date'],
                'is_published' => $def['is_published'],
            ]);

            $exams[] = ['model' => $exam, 'completed' => $def['completed']];

            // ── 2. Build Schedule ─────────────────────────────────────────────────
            $startDate = new \DateTime($def['start_date']);
            $dayOffset = 0;

            foreach ($classes as $class) {
                foreach ($subjects as $si => $subject) {
                    // Skip weekends
                    $date = clone $startDate;
                    $date->modify("+{$dayOffset} days");
                    while (in_array($date->format('N'), ['6', '7'])) {
                        $date->modify('+1 day');
                    }

                    [$start, $end] = $timeSlots[$si % count($timeSlots)];

                    ExamSchedule::create([
                        'branch_id'     => $branchId,
                        'exam_id'       => $exam->id,
                        'class_id'      => $class->id,
                        'subject_id'    => $subject->id,
                        'exam_date'     => $date->format('Y-m-d'),
                        'start_time'    => $start,
                        'end_time'      => $end,
                        'room_number'   => $rooms[$class->numeric_value % count($rooms)],
                        'max_marks'     => 100,
                        'passing_marks' => 40,
                    ]);
                    $scheduleCount++;

                    if ($si % 2 === 1) $dayOffset++;  // advance date every 2 subjects
                }
                $dayOffset++;
            }
        }

        $this->command->info("✓ " . count($exams) . " exams created.");
        $this->command->info("✓ {$scheduleCount} exam schedules created.");

        // ── 3. Results for completed exam only ────────────────────────────────────
        $completedExam = collect($exams)->firstWhere('completed', true)['model'] ?? null;

        if ($completedExam) {
            $students = StudentProfile::with('student')->get()->groupBy('class_id');

            foreach ($completedExam->schedules as $schedule) {
                $classStudents = $students->get($schedule->class_id, collect());

                foreach ($classStudents as $profile) {
                    if (! $profile->student) continue;

                    $marks = rand(35, 100);
                    $grade = $this->calcGrade($marks);

                    ExamResult::create([
                        'branch_id'      => $branchId,
                        'exam_id'        => $completedExam->id,
                        'student_id'     => $profile->student->id,
                        'subject_id'     => $schedule->subject_id,
                        'marks_obtained' => $marks,
                        'grade'          => $grade,
                        'remarks'        => $marks < 40 ? 'Needs improvement' : null,
                        'published_at'   => now(),
                    ]);
                    $resultCount++;
                }
            }
        }

        $this->command->info("✓ {$resultCount} exam results created.");
    }

    private function calcGrade(int $marks): string
    {
        return match(true) {
            $marks >= 90 => 'A+',
            $marks >= 80 => 'A',
            $marks >= 70 => 'B',
            $marks >= 60 => 'C',
            $marks >= 50 => 'D',
            default      => 'F',
        };
    }
}
