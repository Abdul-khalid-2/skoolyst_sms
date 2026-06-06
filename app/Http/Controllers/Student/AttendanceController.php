<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Display the authenticated student's attendance overview.
     */
    public function index(Request $request): View
    {
        $student = auth()->user()->load(['studentProfile.class', 'studentProfile.section']);
        $studentId = $student->id;

        // Resolve the selected month (defaults to the current month).
        $selectedMonth = $this->resolveMonth($request->input('month'));
        $prevMonth = $selectedMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $selectedMonth->copy()->addMonth()->format('Y-m');

        // All-time statistics for the student.
        $overallStats = $this->buildStats(
            Attendance::where('user_id', $studentId)
                ->whereHas('session')
                ->get()
        );

        // Records for the selected month.
        $monthlyRecords = Attendance::where('user_id', $studentId)
            ->whereHas('session', function ($q) use ($selectedMonth) {
                $q->whereYear('date', $selectedMonth->year)
                  ->whereMonth('date', $selectedMonth->month);
            })
            ->with([
                'session.schoolClass',
                'session.section',
                'session.timeTable.class',
                'session.timeTable.section',
            ])
            ->get()
            ->sortByDesc(fn ($att) => $att->session->date)
            ->values();

        $monthStats = $this->buildStats($monthlyRecords);

        // Calendar events for the selected month, colour-coded by status.
        $calendarEvents = $monthlyRecords
            ->filter(fn ($att) => $att->session && $att->session->date)
            ->map(function ($att) {
                $map = [
                    'present' => ['Present', '#00c292'],
                    'absent'  => ['Absent', '#fb9678'],
                    'late'    => ['Late', '#fec107'],
                ];
                [$label, $color] = $map[$att->status] ?? ['Marked', '#03a9f3'];

                return [
                    'title' => $label,
                    'start' => Carbon::parse($att->session->date)->format('Y-m-d'),
                    'color' => $color,
                ];
            })
            ->values();

        return view('app.student.attendance', compact(
            'student',
            'overallStats',
            'monthStats',
            'monthlyRecords',
            'calendarEvents',
            'selectedMonth',
            'prevMonth',
            'nextMonth'
        ));
    }

    /**
     * Parse a "Y-m" string into a Carbon instance, falling back to the current month.
     */
    private function resolveMonth(?string $month): Carbon
    {
        if ($month) {
            try {
                return Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            } catch (\Throwable $e) {
                // Ignore malformed input and fall back below.
            }
        }

        return Carbon::now()->startOfMonth();
    }

    /**
     * Build present/absent/late/percentage statistics from a collection of records.
     */
    private function buildStats($records): array
    {
        $total   = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent  = $records->where('status', 'absent')->count();
        $late    = $records->where('status', 'late')->count();

        // Late is still counted as having attended for the percentage.
        $attended = $present + $late;
        $percentage = $total > 0 ? round(($attended / $total) * 100, 1) : 0;

        return compact('total', 'present', 'absent', 'late', 'percentage');
    }
}
