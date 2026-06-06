<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Classes;
use App\Models\Notice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class NoticesSeeder extends Seeder
{
    public function run(): void
    {
        if (Notice::count() > 0) {
            $this->command->info('Notices already seeded. Skipping.');
            return;
        }

        $branchId   = Branch::query()->value('id') ?? 1;
        $classIds   = Classes::where('branch_id', $branchId)->pluck('id')->all();
        $today      = Carbon::today();

        $noticeDefs = [
            [
                'title'        => 'Annual Sports Day 2026',
                'content'      => "We are excited to announce the Annual Sports Day will be held on the school ground.\n\nAll students are encouraged to participate in the various track and field events. Parents are warmly invited to attend and cheer for their children. Refreshments will be provided.\n\nPlease coordinate with your class teachers for event registration.",
                'roles'        => ['student', 'parent', 'teacher'],
                'classes'      => [],
                'start'        => $today->copy()->addDays(3),
                'end'          => $today->copy()->addDays(20),
                'published'    => true,
            ],
            [
                'title'        => 'Parent-Teacher Meeting',
                'content'      => "A Parent-Teacher Meeting is scheduled for all classes this coming Saturday from 9:00 AM to 1:00 PM.\n\nParents are requested to meet the respective subject teachers to discuss their child's academic progress and the recent examination results.",
                'roles'        => ['parent', 'teacher'],
                'classes'      => [],
                'start'        => $today->copy()->addDays(2),
                'end'          => $today->copy()->addDays(9),
                'published'    => true,
            ],
            [
                'title'        => 'Mid-Term Examination Schedule Released',
                'content'      => "The Mid-Term Examination schedule has been published. Examinations will commence from the 10th of this month.\n\nStudents should check the exam timetable on the notice board and prepare accordingly. Admit cards will be distributed by class teachers.",
                'roles'        => ['student', 'parent'],
                'classes'      => $classIds,
                'start'        => $today->copy()->subDays(2),
                'end'          => $today->copy()->addDays(15),
                'published'    => true,
            ],
            [
                'title'        => 'Library Books Return Reminder',
                'content'      => "All students who have borrowed books from the school library are reminded to return them before the end of this month to avoid late fines.\n\nThe library will remain open during regular school hours for returns and new issues.",
                'roles'        => ['student'],
                'classes'      => [],
                'start'        => $today->copy()->subDays(5),
                'end'          => $today->copy()->addDays(10),
                'published'    => true,
            ],
            [
                'title'        => 'Staff Meeting — All Teachers',
                'content'      => "A mandatory staff meeting for all teaching faculty will be held in the conference room after school hours on Friday.\n\nAgenda includes curriculum planning, upcoming events, and administrative updates.",
                'roles'        => ['teacher', 'admin'],
                'classes'      => [],
                'start'        => $today->copy()->addDays(1),
                'end'          => $today->copy()->addDays(4),
                'published'    => true,
            ],
            [
                'title'        => 'Fee Submission Deadline',
                'content'      => "This is a reminder that the monthly tuition fee for the current term is due by the 10th.\n\nKindly clear all outstanding dues at the accounts office. A late fee will be applicable after the due date.",
                'roles'        => ['parent', 'accountant'],
                'classes'      => [],
                'start'        => $today->copy()->subDays(1),
                'end'          => $today->copy()->addDays(8),
                'published'    => true,
            ],
            [
                'title'        => 'Independence Day Celebration',
                'content'      => "The school will celebrate Independence Day with a flag hoisting ceremony, speeches, and cultural performances by students.\n\nAttendance is mandatory for all students in proper school uniform.",
                'roles'        => [],
                'classes'      => [],
                'start'        => $today->copy()->subDays(40),
                'end'          => $today->copy()->subDays(30),
                'published'    => true,
            ],
            [
                'title'        => 'Winter Break Announcement (Draft)',
                'content'      => "Tentative dates for the winter vacation are being finalized. Details regarding the holiday homework and reopening date will be shared soon.\n\nThis notice is awaiting final approval.",
                'roles'        => ['student', 'parent', 'teacher'],
                'classes'      => [],
                'start'        => $today->copy()->addDays(30),
                'end'          => $today->copy()->addDays(60),
                'published'    => false,
            ],
        ];

        foreach ($noticeDefs as $def) {
            Notice::create([
                'branch_id'      => $branchId,
                'title'          => $def['title'],
                'content'        => $def['content'],
                'target_roles'   => $def['roles']   ?: null,
                'target_classes' => $def['classes'] ?: null,
                'start_date'     => $def['start']->format('Y-m-d'),
                'end_date'       => $def['end']->format('Y-m-d'),
                'is_published'   => $def['published'],
            ]);
        }

        $this->command->info('✓ ' . count($noticeDefs) . ' notices created.');
    }
}
