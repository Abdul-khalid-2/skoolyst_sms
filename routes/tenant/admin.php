<?php

declare(strict_types=1);

use App\Http\Controllers\App\{
    ProfileController,
    UserController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    TeacherController,
    StudentController,
    ParentController,
    ClassesController,
    SectionController,
    SubjectController,
    SchoolProfileController,
};
use App\Http\Controllers\Timetable\{
    TimetableController
};
use App\Http\Controllers\Attendance\{
    AttendanceController
};
use App\Models\School;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
    require __DIR__ . '/tenant-auth.php';
});
