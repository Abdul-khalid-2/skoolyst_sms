<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Classes;
use App\Models\Section;
use App\Models\StudentProfile;
use App\Models\Subject;
use App\Models\TeacherProfile;
use App\Models\TeacherSubject;
use App\Models\TimeTable;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', 'teacher')->count() > 0) {
            $this->command->info('Test data already seeded. Skipping.');
            return;
        }

        // ─── Step 1: Resolve Branch ──────────────────────────────────────────────
        $branch = Branch::first() ?? Branch::create([
            'name'      => 'Main Branch',
            'address'   => 'Hyderabad',
            'phone'     => '0300-0000000',
            'email'     => 'main@skoolyst.com',
            'is_active' => true,
        ]);
        $branchId = $branch->id;

        // ─── Step 2: Create Classes ───────────────────────────────────────────────
        $classes = [];
        for ($num = 1; $num <= 6; $num++) {
            $classes[$num] = Classes::firstOrCreate(
                ['name' => "Class $num", 'branch_id' => $branchId],
                ['numeric_value' => $num]
            );
        }
        $this->command->info("✓ 6 classes created.");

        // ─── Step 3: Create Sections ──────────────────────────────────────────────
        $sections        = [];
        $sectionsByClass = [];
        foreach ($classes as $classNum => $class) {
            foreach (['A', 'B'] as $sectionName) {
                $section = Section::firstOrCreate(
                    ['class_id' => $class->id, 'name' => $sectionName],
                    ['branch_id' => $branchId, 'capacity' => 30]
                );
                $sections[]                              = $section;
                $sectionsByClass[$class->id][]           = $section;
            }
        }
        $this->command->info("✓ 12 sections created.");

        // ─── Step 4: Create Subjects ──────────────────────────────────────────────
        $subjectDefinitions = [
            'MATH' => 'Mathematics',
            'ENG'  => 'English',
            'URD'  => 'Urdu',
            'SCI'  => 'Science',
            'SS'   => 'Social Studies',
            'ISL'  => 'Islamiat',
            'CS'   => 'Computer Science',
            'PHY'  => 'Physics',
            'CHEM' => 'Chemistry',
            'BIO'  => 'Biology',
        ];
        $subjects = [];
        foreach ($subjectDefinitions as $code => $name) {
            $subjects[$code] = Subject::firstOrCreate(
                ['code' => $code, 'branch_id' => $branchId],
                ['name' => $name]
            );
        }
        $this->command->info("✓ 10 subjects created.");

        // ─── Step 5: Admin User (already created by DatabaseSeeder — ensure exists) ─
        $admin = User::firstOrCreate(
            ['email' => 'admin@skoolyst.com'],
            [
                'name'      => 'School Admin',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'status'    => 'active',
                'branch_id' => $branchId,
            ]
        );
        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // ─── Step 6: Create Teachers ──────────────────────────────────────────────
        $teacherDefinitions = [
            // [name, email, gender, phone, dob, [subject codes], joining_date, exp_years]
            ['Muhammad Ali',  'ali.teacher@skoolyst.com',    'male',   '0300-1111111', '1985-03-15', ['MATH', 'SCI'],  '2020-01-15', 8],
            ['Fatima Khan',   'fatima.teacher@skoolyst.com', 'female', '0300-2222222', '1988-06-20', ['ENG',  'URD'],  '2020-06-01', 7],
            ['Ahmed Raza',    'ahmed.teacher@skoolyst.com',  'male',   '0300-3333333', '1983-11-10', ['PHY',  'CHEM'], '2021-03-01', 10],
            ['Sana Malik',    'sana.teacher@skoolyst.com',   'female', '0300-4444444', '1990-09-05', ['BIO',  'SS'],   '2021-09-01', 6],
            ['Usman Tariq',   'usman.teacher@skoolyst.com',  'male',   '0300-5555555', '1987-04-25', ['CS',   'MATH'], '2022-01-10', 5],
            ['Ayesha Noor',   'ayesha.teacher@skoolyst.com', 'female', '0300-6666666', '1992-07-18', ['URD',  'ISL'],  '2022-06-01', 4],
            ['Bilal Sheikh',  'bilal.teacher@skoolyst.com',  'male',   '0300-7777777', '1986-12-30', ['CHEM', 'BIO'],  '2022-09-01', 3],
            ['Zara Ahmed',    'zara.ahmed@skoolyst.com',     'female', '0300-8888888', '1991-02-14', ['ENG',  'SS'],   '2023-06-01', 2],
        ];

        $teachers           = [];  // 1-indexed, matching $teacherDefinitions order
        $teacherBySubject   = [];  // subjectCode => first Teacher User assigned

        foreach ($teacherDefinitions as $idx => $td) {
            [$name, $email, $gender, $phone, $dob, $subjectCodes, $joining, $expYears] = $td;
            $position = $idx + 1;

            $teacher = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'      => $name,
                    'password'  => Hash::make('password'),
                    'role'      => 'teacher',
                    'status'    => 'active',
                    'branch_id' => $branchId,
                    'gender'    => $gender,
                    'phone'     => $phone,
                    'dob'       => $dob,
                ]
            );

            if (! $teacher->hasRole('teacher')) {
                $teacher->assignRole('teacher');
            }

            // First 6 teachers are class teachers (one per class)
            $isClassTeacher = $position <= 6;

            TeacherProfile::firstOrCreate(
                ['teacher_id' => $teacher->id],
                [
                    'branch_id'        => $branchId,
                    'employee_id'      => 'EMP-' . str_pad($position, 3, '0', STR_PAD_LEFT),
                    'qualification'    => 'B.Ed',
                    'specialization'   => implode(', ', $subjectCodes),
                    'experience_years' => $expYears,
                    'joining_date'     => $joining,
                    'is_class_teacher' => $isClassTeacher,
                ]
            );

            $teachers[$position] = $teacher;

            foreach ($subjectCodes as $code) {
                if (! isset($teacherBySubject[$code])) {
                    $teacherBySubject[$code] = $teacher;
                }
            }
        }

        // Assign class teacher_id on each class, and update profile class_teacher_of
        foreach ($classes as $classNum => $class) {
            if (isset($teachers[$classNum])) {
                $class->teacher_id = $teachers[$classNum]->id;
                $class->save();

                TeacherProfile::where('teacher_id', $teachers[$classNum]->id)
                    ->update(['class_teacher_of' => $class->id]);
            }
        }
        $this->command->info("✓ 8 teachers created with profiles.");

        // ─── Step 7: Assign Subjects to Teachers ─────────────────────────────────
        foreach ($teacherDefinitions as $idx => $td) {
            $teacher      = $teachers[$idx + 1];
            $subjectCodes = $td[5];

            foreach ($subjectCodes as $code) {
                // firstOrCreate handles null class_id correctly (WHERE class_id IS NULL)
                TeacherSubject::firstOrCreate([
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subjects[$code]->id,
                    'class_id'   => null,
                ], [
                    'is_class_teacher' => 0,
                ]);
            }
        }
        $this->command->info("✓ Teacher-subject assignments created.");

        // ─── Step 8: Create Accountants ──────────────────────────────────────────
        $accountants = [
            ['Kamran Accounts', 'kamran.acc@skoolyst.com', 'male'],
            ['Nadia Accounts',  'nadia.acc@skoolyst.com',  'female'],
        ];
        foreach ($accountants as [$accName, $accEmail, $accGender]) {
            $acc = User::firstOrCreate(
                ['email' => $accEmail],
                [
                    'name'      => $accName,
                    'password'  => Hash::make('password'),
                    'role'      => 'accountant',
                    'status'    => 'active',
                    'branch_id' => $branchId,
                    'gender'    => $accGender,
                ]
            );
            if (! $acc->hasRole('accountant')) {
                $acc->assignRole('accountant');
            }
        }
        $this->command->info("✓ 2 accountants created.");

        // ─── Step 9: Create Students ──────────────────────────────────────────────
        $maleNames   = ['Hamza', 'Bilal', 'Omar', 'Zaid', 'Hassan', 'Ibrahim', 'Yusuf', 'Tariq', 'Saad', 'Faisal', 'Asad', 'Raza'];
        $femaleNames = ['Fatima', 'Ayesha', 'Zara', 'Sana', 'Hina', 'Noor', 'Sara', 'Maryam', 'Amna', 'Rabia', 'Iqra', 'Mahnoor'];
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

        $studentCounter = 1;
        $maleIdx        = 0;
        $femaleIdx      = 0;

        foreach ($classes as $classNum => $class) {
            // Class 1 students ~age 6 (born ~2019), Class 6 ~age 11 (born ~2014)
            $birthYear       = 2020 - $classNum;
            $classSections   = $sectionsByClass[$class->id] ?? [];
            $studentsPerSect = [0 => 0, 1 => 0];  // section-slot index => count placed

            for ($i = 0; $i < 8; $i++) {
                $sectSlot = $i < 4 ? 0 : 1;   // 0 = Section A, 1 = Section B
                $section  = $classSections[$sectSlot];
                $studentsPerSect[$sectSlot]++;

                $isMale = ($i % 2 === 0);
                if ($isMale) {
                    $firstName = $maleNames[$maleIdx % count($maleNames)];
                    $maleIdx++;
                } else {
                    $firstName = $femaleNames[$femaleIdx % count($femaleNames)];
                    $femaleIdx++;
                }

                $admissionNo = sprintf('%d-%s-%02d', $classNum, $section->name, $studentsPerSect[$sectSlot]);
                $dob         = sprintf(
                    '%04d-%02d-%02d',
                    $birthYear,
                    rand(1, 12),
                    rand(1, 28)
                );

                $student = User::firstOrCreate(
                    ['email' => "student{$studentCounter}@skoolyst.com"],
                    [
                        'name'      => $firstName . ' Student',
                        'password'  => Hash::make('password'),
                        'role'      => 'student',
                        'status'    => 'active',
                        'branch_id' => $branchId,
                        'gender'    => $isMale ? 'male' : 'female',
                        'dob'       => $dob,
                    ]
                );

                if (! $student->hasRole('student')) {
                    $student->assignRole('student');
                }

                StudentProfile::firstOrCreate(
                    ['student_id' => $student->id],
                    [
                        'branch_id'      => $branchId,
                        'admission_no'   => $admissionNo,
                        'admission_date' => '2024-04-01',
                        'class_id'       => $class->id,
                        'section_id'     => $section->id,
                        'blood_group'    => $bloodGroups[$studentCounter % count($bloodGroups)],
                        'id_card_issued' => false,
                    ]
                );

                $studentCounter++;
            }
        }
        $this->command->info("✓ 48 students created with profiles.");

        // ─── Step 10: Create Timetable (Class 1 & 2 only) ────────────────────────
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // 6 periods — schema unique key: (class_id, section_id, day_of_week, start_time)
        $periods = [
            ['Period 1', '08:00', '08:45'],
            ['Period 2', '08:45', '09:30'],
            ['Period 3', '09:30', '10:15'],
            ['Period 4', '10:30', '11:15'],
            ['Period 5', '11:15', '12:00'],
            ['Period 6', '12:00', '12:45'],
        ];

        // Subject rotation aligned with period index
        $timetableCodes = ['MATH', 'ENG', 'URD', 'SCI', 'SS', 'ISL'];

        foreach ([1, 2] as $classNum) {
            $class         = $classes[$classNum];
            $classSections = $sectionsByClass[$class->id] ?? [];

            foreach ($classSections as $section) {
                foreach ($days as $day) {
                    foreach ($periods as $periodIdx => [$periodName, $startTime, $endTime]) {
                        $code    = $timetableCodes[$periodIdx];
                        $subject = $subjects[$code];
                        // Prefer the teacher whose primary subject is $code;
                        // fall back to teacher 1 (Muhammad Ali) if no mapping.
                        $teacher = $teacherBySubject[$code] ?? $teachers[1];

                        TimeTable::firstOrCreate(
                            [
                                'class_id'    => $class->id,
                                'section_id'  => $section->id,
                                'day_of_week' => $day,
                                'start_time'  => $startTime,
                            ],
                            [
                                'branch_id'      => $branchId,
                                'subject_id'     => $subject->id,
                                'teacher_id'     => $teacher->id,
                                'end_time'       => $endTime,
                                'period_name'    => $periodName,
                                'is_break'       => false,
                                'is_recurring'   => true,
                                'effective_from' => now()->startOfYear()->toDateString(),
                            ]
                        );
                    }
                }
            }
        }
        $this->command->info("✓ Timetable created for Class 1 and Class 2.");

        // ─── Summary ─────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('Test Data Seeded Successfully:');
        $this->command->info('- 6 Classes with 12 Sections (A & B each)');
        $this->command->info('- 10 Subjects');
        $this->command->info('- 8 Teachers with profiles and subject assignments');
        $this->command->info('- 2 Accountants');
        $this->command->info('- 48 Students (8 per class) with profiles');
        $this->command->info('- Timetable for Class 1 and Class 2');
        $this->command->info("- Login: teacher emails use password 'password'");
        $this->command->info("- Login: student emails use password 'password'");
    }
}
