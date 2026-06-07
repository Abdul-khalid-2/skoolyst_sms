<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\ScopesTeacherAssignments;
use App\Models\Attendance;
use App\Models\ExamResult;
use App\Models\StudentProfile;
use Illuminate\View\View;

class ReportController extends Controller
{
    use ScopesTeacherAssignments;

    public function index(): View
    {
        $pairs = $this->allowedPairs();
        $classStats = [];

        foreach ($pairs->groupBy('class_id') as $classId => $classPairs) {
            $sectionIds = $classPairs->pluck('section_id')->unique();
            $studentIds = StudentProfile::where('class_id', $classId)
                ->whereIn('section_id', $sectionIds)
                ->pluck('student_id');

            $total = Attendance::whereIn('user_id', $studentIds)->count();
            $present = Attendance::whereIn('user_id', $studentIds)->where('status', 'present')->count();
            $results = ExamResult::whereIn('student_id', $studentIds)->count();

            $class = \App\Models\Classes::find($classId);

            $classStats[] = [
                'class'      => $class?->name ?? 'Class',
                'students'   => $studentIds->count(),
                'attendance' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
                'results'    => $results,
            ];
        }

        return view('app.teacher.reports.index', compact('classStats'));
    }
}
