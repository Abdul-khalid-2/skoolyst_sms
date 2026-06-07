<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AcademicSetupController extends Controller
{
    public function index(): View
    {
        $steps = [
            ['title' => 'Classes', 'desc' => 'Manage classes and numeric order', 'route' => 'admin.academic.classes.index', 'icon' => 'fa-graduation-cap'],
            ['title' => 'Sections', 'desc' => 'Manage sections per class', 'route' => 'admin.academic.sections.index', 'icon' => 'fa-th-large'],
            ['title' => 'Subject Catalog', 'desc' => 'Master list of subjects', 'route' => 'admin.academic.subjects.index', 'icon' => 'fa-book'],
            ['title' => 'Class Curriculum', 'desc' => 'Assign subjects to each class', 'route' => 'admin.academic.subjects.assign', 'icon' => 'fa-list-alt'],
            ['title' => 'Section Teachers', 'desc' => 'Allocate teachers per section & subject', 'route' => 'admin.academic.subjects.section_teacher', 'icon' => 'fa-user-plus'],
            ['title' => 'Timetable', 'desc' => 'Weekly period schedule', 'route' => 'admin.timetable.index', 'icon' => 'fa-calendar'],
        ];

        return view('app.admin.academic.setup', compact('steps'));
    }
}
