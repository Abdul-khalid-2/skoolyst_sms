<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Holiday;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HolidaysSeeder extends Seeder
{
    public function run(): void
    {
        if (Holiday::count() > 0) {
            $this->command->info('Holidays already seeded. Skipping.');
            return;
        }

        $branchId = Branch::query()->value('id') ?? 1;
        $year     = now()->year;

        // [title, start, end, is_recurring, pattern, description]
        $holidayDefs = [
            ['New Year\'s Day',        "$year-01-01", "$year-01-01", true,  'yearly',  'Public holiday marking the start of the new year.'],
            ['Kashmir Day',           "$year-02-05", "$year-02-05", true,  'yearly',  'Solidarity day observed nationwide.'],
            ['Pakistan Day',          "$year-03-23", "$year-03-23", true,  'yearly',  'Commemorating the Lahore Resolution of 1940.'],
            ['Spring Break',          "$year-03-25", "$year-03-29", false, null,      'Short spring vacation for all students.'],
            ['Labour Day',            "$year-05-01", "$year-05-01", true,  'yearly',  'International Workers\' Day.'],
            ['Eid-ul-Fitr',           "$year-04-10", "$year-04-13", false, null,      'Festival marking the end of Ramadan. Dates are subject to moon sighting.'],
            ['Summer Vacation',       "$year-06-01", "$year-07-31", false, null,      'Annual summer break for students and teaching staff.'],
            ['Eid-ul-Adha',           "$year-06-17", "$year-06-20", false, null,      'Festival of sacrifice. Dates are subject to moon sighting.'],
            ['Independence Day',      "$year-08-14", "$year-08-14", true,  'yearly',  'Celebrating the independence of Pakistan in 1947.'],
            ['Iqbal Day',             "$year-11-09", "$year-11-09", true,  'yearly',  'Birthday of poet-philosopher Allama Muhammad Iqbal.'],
            ['Quaid-e-Azam Day',      "$year-12-25", "$year-12-25", true,  'yearly',  'Birthday of the founder, Muhammad Ali Jinnah.'],
            ['Winter Vacation',       "$year-12-22", ($year + 1) . '-01-02', false, null, 'Year-end winter break.'],
        ];

        foreach ($holidayDefs as [$title, $start, $end, $recurring, $pattern, $desc]) {
            Holiday::create([
                'branch_id'         => $branchId,
                'title'             => $title,
                'description'       => $desc,
                'start_date'        => $start,
                'end_date'          => $end,
                'is_recurring'      => $recurring,
                'recurring_pattern' => $pattern,
            ]);
        }

        $this->command->info('✓ ' . count($holidayDefs) . ' holidays created.');
    }
}
