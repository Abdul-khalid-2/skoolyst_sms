<?php

// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//     Route::resource('tenant', TenantController::class);
//     Route::get('tenants', [TenantController::class, 'index'])->name('tenants.index');
//     Route::post('tenants', [TenantController::class, 'store'])->name('tenants.store');
// });


use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

Route::get('/install-composer-dependencies', function () {
    // SECURITY WARNING: This should be protected in production!

    $process = new Process(['composer', 'install']);
    $process->setWorkingDirectory(base_path());
    $process->setTimeout(300); // 5 minutes

    try {
        $process->mustRun();
        return response()->json([
            'success' => true,
            'output' => $process->getOutput()
        ]);
    } catch (ProcessFailedException $exception) {
        return response()->json([
            'success' => false,
            'error' => $exception->getMessage(),
            'output' => $process->getErrorOutput()
        ], 500);
    }
})->middleware('auth'); // At minimum, add authentication

Route::get('/', function () {
    $school = School::with(['programs', 'testimonials'])->first();

    if (!$school) {
        // Fallback to default data if no school exists
        $school = [
            'name' => 'Greenwood International School',
            'motto' => 'Learning for Life, Excellence in Education',
            'logo' => null,
            'hero_image' => null,
            'established_year' => '1998',
            'student_count' => '1250+',
            'teacher_count' => '85+',
            'facility_count' => '30+',
            'primary_color' => '#2563eb',
            'secondary_color' => '#1e40af',
            'address' => '123 Education Avenue, Springfield, ST 12345',
            'phone' => '+1 (555) 123-4567',
            'email' => 'info@greenwood.edu',
            'short_description' => 'Greenwood International provides a world-class education with a focus on holistic development and academic excellence.',
            'programs' => [
                (object)[
                    'name' => 'Early Years Program',
                    'description' => 'Play-based learning for ages 3-5 focusing on social, emotional and cognitive development'
                ],
                // ... other default programs
            ],
            'testimonials' => [
                (object)[
                    'author' => 'Sarah Johnson',
                    'role' => 'Parent of 3rd Grader',
                    'content' => 'The teachers at Greenwood truly care about each student. My daughter has flourished both academically and socially.',
                    'rating' => 5,
                    'avatar' => null
                ],
                // ... other default testimonials
            ]
        ];
        $school = (object)$school;
    }

    return view('app.welcome', compact('school'));
});

use Illuminate\Support\Facades\Auth;

Route::get('/custom_logout', function () {

    Auth::logout();
});

Route::group(['middleware' => ['role:admin|super-admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    // Parent
    Route::get('/parents', [ParentController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.parents');
    Route::post('/add_parent', [ParentController::class, 'Store'])->middleware(['auth', 'verified'])->name('admin.store.parent');
    Route::get('/add_parent', [ParentController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard.add.parent');
    Route::get('/edit_parent', [ParentController::class, 'edit'])->middleware(['auth', 'verified'])->name('admin.edit.parent');
    Route::post('/edit_parent', [ParentController::class, 'update'])->middleware(['auth', 'verified'])->name('admin.update.parent');
    Route::get('/destroy_parent/{encryptedId}', [ParentController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.destroy.parent');

    // Student
    Route::get('/students', [StudentController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.students');
    Route::get('/add_student', [StudentController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard.add.student');
    Route::post('/add_student', [StudentController::class, 'store'])->middleware(['auth', 'verified'])->name('admin.store.student');
    Route::get('/edit_student', [StudentController::class, 'edit'])->middleware(['auth', 'verified'])->name('admin.edit.student');
    Route::post('/edit_student', [StudentController::class, 'update'])->middleware(['auth', 'verified'])->name('admin.update.student');
    Route::delete('/destroy_student', [StudentController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.destroy.student');
    Route::get('/get-sections/{classId}', [StudentController::class, 'getSections'])->middleware(['auth', 'verified']);

    // Teacher
    Route::get('/teachers', [TeacherController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.teachers');
    Route::get('/add_teacher', [TeacherController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard.add.teacher');
    Route::post('/add_teacher', [TeacherController::class, 'store'])->middleware(['auth', 'verified'])->name('admin.store.teacher');
    Route::get('/edit_teacher/{id?}', [TeacherController::class, 'edit'])->middleware(['auth', 'verified'])->name('admin.edit.teacher');
    Route::get('/teacher/{id?}', [TeacherController::class, 'show'])->middleware(['auth', 'verified'])->name('admin.show.teacher');
    Route::put('/edit_teacher/{id?}', [TeacherController::class, 'update'])->middleware(['auth', 'verified'])->name('admin.update.teacher');
    Route::delete('/destroy_teacher', [TeacherController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.destroy.teacher');
    Route::post('/teacher/status-update', [TeacherController::class, 'updateStatus'])->name('teacher.update.status');

    // Class Routes
    Route::prefix('classes')->middleware(['auth', 'verified'])->name('admin.academic.classes.')->group(function () {
        Route::get('/', [ClassesController::class, 'index'])->name('index');
        Route::get('/create', [ClassesController::class, 'create'])->name('create');
        Route::post('/', [ClassesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ClassesController::class, 'edit'])->name('edit');
        Route::get('/{id}/show', [ClassesController::class, 'show'])->name('show');
        Route::put('/{id}', [ClassesController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClassesController::class, 'destroy'])->name('destroy'); // <-- DELETE route
        Route::post('/{id}/restore', [ClassesController::class, 'restore'])->name('restore');
    });

    // Section Routes
    Route::prefix('sections')->middleware(['auth', 'verified'])->name('admin.academic.sections.')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('index');
        Route::get('/create', [SectionController::class, 'create'])->name('create');
        Route::post('/', [SectionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SectionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SectionController::class, 'update'])->name('update');
        Route::delete('/{id}', [SectionController::class, 'destroy'])->name('destroy');
    });
    Route::get('/get-sections/{class_id}', [SectionController::class, 'getSectionsByClass']);

    // Subject Routes
    Route::prefix('subjects')->middleware(['auth', 'verified'])->name('admin.academic.subjects.')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('index');
        Route::get('/create', [SubjectController::class, 'create'])->name('create');
        Route::post('/', [SubjectController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SubjectController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SubjectController::class, 'update'])->name('update');
        Route::delete('/{id}', [SubjectController::class, 'destroy'])->name('destroy');
    });
    Route::get('subject_assign/', [SubjectController::class, 'assign'])->name('admin.academic.subjects.assign');
    Route::post('subject_assign/', [SubjectController::class, 'assignTeacherStore'])->name('admin.academic.subjects.assign_teacher');
    Route::post('/subjects/assign-class-teacher', [SubjectController::class, 'assignClassTeacherStore'])->name('admin.academic.subjects.assign_class_teacher');

    Route::middleware(['auth', 'verified'])->group(function () {
        // School Profile Routes
        Route::get('/cms', [SchoolProfileController::class, 'cms'])->name('schools.cms');
        Route::put('/cms_update', [SchoolProfileController::class, 'cmsUpdate'])->name('schools.cms.update');
        Route::get('/school', [SchoolProfileController::class, 'index'])->name('schools.show');
        Route::get('/schools/edit', [SchoolProfileController::class, 'edit'])->name('schools.edit');
        Route::put('/schools', [SchoolProfileController::class, 'update'])->name('schools.update');

        // School Settings Routes
        Route::prefix('schools/settings')->group(function () {
            Route::get('/', [SchoolProfileController::class, 'showSettings'])->name('schools.settings');
            Route::put('/', [SchoolProfileController::class, 'updateSettings'])->name('schools.update-settings');
            Route::put('/academic', [SchoolProfileController::class, 'updateAcademicSettings'])->name('schools.update-academic-settings');
            Route::put('/attendance', [SchoolProfileController::class, 'updateAttendanceSettings'])->name('schools.update-attendance-settings');
        });
    });

    // User Profile
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::resource('user', UserController::class);
    });

    // Timetable
    Route::prefix('timetable')->middleware(['auth', 'verified'])->name('admin.timetable.')->group(function () {
        Route::get('/', [TimetableController::class, 'index'])->name('index');
        Route::get('/create', [TimetableController::class, 'create'])->name('create');
        Route::post('/', [TimetableController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TimetableController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TimetableController::class, 'update'])->name('update');
        Route::delete('/{id}', [TimetableController::class, 'destroy'])->name('destroy');
    });
    Route::get('create_schedule', [TimetableController::class, 'create_schedule'])->name('admin.timetable.create.schedule');
    Route::post('store_schedule', [TimetableController::class, 'store_schedule'])->name('admin.timetable.store.schedule');
    Route::get('/admin/get-teachers-by-subject', [TimetableController::class, 'getTeachersBySubject'])->name('admin.getTeachersBySubject');

    // Attendance
    // Attendance Routes
    Route::prefix('attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('admin.attendance.index');
        Route::get('/take', [AttendanceController::class, 'create'])->name('admin.attendance.create');

        // AJAX endpoints
        Route::get('/get-sections', [AttendanceController::class, 'getSections'])->name('attendance.get-sections');
        Route::get('/get-subjects', [AttendanceController::class, 'getSubjects'])->name('attendance.get-subjects');
        Route::get('/get-students', [AttendanceController::class, 'getStudents'])->name('attendance.get-students');
        Route::post('/save', [AttendanceController::class, 'store'])->name('attendance.store');
    });
    Route::get('/check-classes', [AttendanceController::class, 'checkClasses']);
    Route::get('/attendance/trends', [AttendanceController::class, 'getAttendanceTrends']);
});



















require __DIR__ . '/auth.php';
