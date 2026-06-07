<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request, User $student): View
    {
        $this->authorize('view', $student);

        $student->load(['studentProfile.class', 'studentProfile.section']);
        $studentId = $student->id;

        $selectedMonth = $this->resolveMonth($request->input('month'));
        $prevMonth = $selectedMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $selectedMonth->copy()->addMonth()->format('Y-m');

        $overallStats = $this->buildStats(
            Attendance::where('user_id', $studentId)->whereHas('session')->get()
        );

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

        $children = auth()->user()->children()->orderBy('name')->get();

        return view('app.parent.attendance.index', compact(
            'student',
            'children',
            'overallStats',
            'monthStats',
            'monthlyRecords',
            'selectedMonth',
            'prevMonth',
            'nextMonth'
        ));
    }

    private function resolveMonth(?string $month): Carbon
    {
        if ($month) {
            try {
                return Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            } catch (\Throwable $e) {
                //
            }
        }

        return Carbon::now()->startOfMonth();
    }

    private function buildStats($records): array
    {
        $total   = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent  = $records->where('status', 'absent')->count();
        $late    = $records->where('status', 'late')->count();
        $percentage = $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0;

        return compact('total', 'present', 'absent', 'late', 'percentage');
    }
}
