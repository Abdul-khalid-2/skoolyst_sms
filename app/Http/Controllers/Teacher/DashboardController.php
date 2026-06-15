<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Teacher\Concerns\ScopesTeacherAssignments;
use App\Models\Attendance;
use App\Models\ExamResult;
use App\Models\StudentProfile;
use App\Services\Teacher\UpcomingClassService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use ScopesTeacherAssignments;

    public function index(): View
    {
        $teacher = auth()->user();
        $pairs   = $this->allowedPairs();

        $studentCount = 0;
        if ($pairs->isNotEmpty()) {
            $studentCount = StudentProfile::where(function ($q) use ($pairs) {
                foreach ($pairs as $pair) {
                    $q->orWhere(function ($inner) use ($pair) {
                        $inner->where('class_id', $pair['class_id'])
                            ->where('section_id', $pair['section_id']);
                    });
                }
            })->count();
        }

        $sectionCount = $pairs->count();
        $subjectCount = $this->allowedSubjectIds()->count();

        $studentIds = StudentProfile::where(function ($q) use ($pairs) {
            foreach ($pairs as $pair) {
                $q->orWhere(function ($inner) use ($pair) {
                    $inner->where('class_id', $pair['class_id'])
                        ->where('section_id', $pair['section_id']);
                });
            }
        })->pluck('student_id');

        $resultsEntered = ExamResult::whereIn('student_id', $studentIds)->count();
        $attendanceRecords = Attendance::whereIn('user_id', $studentIds)->count();

        $upcomingClass = app(UpcomingClassService::class)->getNextForTeacher($teacher);

        return view('app.teacher.dashboard', [
            'teacher'          => $teacher,
            'studentCount'     => $studentCount,
            'sectionCount'     => $sectionCount,
            'subjectCount'     => $subjectCount,
            'resultsEntered'   => $resultsEntered,
            'attendanceRecords'=> $attendanceRecords,
            'upcomingClass'    => $upcomingClass,
        ]);
    }
}
