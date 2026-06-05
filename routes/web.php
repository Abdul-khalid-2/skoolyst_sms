<?php

use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\Attendance\AttendanceController as SessionAttendanceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SidebarSettingController;
use App\Http\Controllers\Timetable\TimetableController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $school = Setting::get();

    return view('app.welcome', ['school' => $school]);
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified', 'scope.branch'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::apiResource('branches', BranchController::class);

    Route::get('/sidebar-settings', [SidebarSettingController::class, 'index'])->name('sidebar.index');
    Route::put('/sidebar-settings/{sidebarSetting}', [SidebarSettingController::class, 'update'])->name('sidebar.update');
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:super-admin|admin'])->group(function () {
    Route::get('/school', [SchoolProfileController::class, 'index'])->name('schools.show');
    Route::get('/schools/edit', [SchoolProfileController::class, 'edit'])->name('schools.edit');
    Route::put('/schools', [SchoolProfileController::class, 'update'])->name('schools.update');
    Route::get('/cms', [SchoolProfileController::class, 'cms'])->name('schools.cms');
    Route::put('/cms_update', [SchoolProfileController::class, 'cmsUpdate'])->name('schools.cms.update');

    Route::prefix('schools/settings')->group(function () {
        Route::get('/', [SchoolProfileController::class, 'showSettings'])->name('schools.settings');
        Route::put('/basic-info', [SchoolProfileController::class, 'updateBasicInfo'])->name('schools.update-basic-info');
        Route::put('/contact-details', [SchoolProfileController::class, 'updateContactDetails'])->name('schools.update-contact-details');
        Route::put('/academic-structure', [SchoolProfileController::class, 'updateAcademicStructure'])->name('schools.update-academic-structure');
        Route::put('/', [SchoolProfileController::class, 'updateSettings'])->name('schools.update-settings');
        Route::put('/academic', [SchoolProfileController::class, 'updateAcademicSettings'])->name('schools.update-academic-settings');
        Route::put('/attendance', [SchoolProfileController::class, 'updateAttendanceSettings'])->name('schools.update-attendance-settings');
        Route::put('/fee', [SchoolProfileController::class, 'updateFeeSettings'])->name('schools.update-fee-settings');
        Route::put('/notifications', [SchoolProfileController::class, 'updateNotificationSettings'])->name('schools.update-notification-settings');
        Route::put('/security', [SchoolProfileController::class, 'updateSecuritySettings'])->name('schools.update-security-settings');
    });

    Route::get('/parents', [ParentController::class, 'index'])->name('dashboard.parents');
    Route::post('/add_parent', [ParentController::class, 'Store'])->name('admin.store.parent');
    Route::get('/add_parent', [ParentController::class, 'create'])->name('dashboard.add.parent');
    Route::get('/edit_parent', [ParentController::class, 'edit'])->name('admin.edit.parent');
    Route::post('/edit_parent', [ParentController::class, 'update'])->name('admin.update.parent');
    Route::get('/destroy_parent/{encryptedId}', [ParentController::class, 'destroy'])->name('admin.destroy.parent');

    Route::get('/students', [StudentController::class, 'index'])->name('dashboard.students');
    Route::get('/add_student', [StudentController::class, 'create'])->name('dashboard.add.student');
    Route::post('/add_student', [StudentController::class, 'store'])->name('admin.store.student');
    Route::get('/show_student/{id}', [StudentController::class, 'show'])->name('admin.show.student');
    Route::get('/edit_student/{id}', [StudentController::class, 'edit'])->name('admin.edit.student');
    Route::put('/edit_student/{id}', [StudentController::class, 'update'])->name('admin.update.student');
    Route::delete('/destroy_student/{id}', [StudentController::class, 'destroy'])->name('admin.destroy.student');
    Route::get('/get-sections/{classId}', [StudentController::class, 'getSections'])->name('students.sections');

    Route::get('/teachers', [TeacherController::class, 'index'])->name('dashboard.teachers');
    Route::get('/add_teacher', [TeacherController::class, 'create'])->name('dashboard.add.teacher');
    Route::post('/add_teacher', [TeacherController::class, 'store'])->name('admin.store.teacher');
    Route::get('/edit_teacher/{id?}', [TeacherController::class, 'edit'])->name('admin.edit.teacher');
    Route::get('/teacher/{id?}', [TeacherController::class, 'show'])->name('admin.show.teacher');
    Route::put('/edit_teacher/{id?}', [TeacherController::class, 'update'])->name('admin.update.teacher');
    Route::delete('/destroy_teacher', [TeacherController::class, 'destroy'])->name('admin.destroy.teacher');
    Route::post('/teacher/status-update', [TeacherController::class, 'updateStatus'])->name('teacher.update.status');

    Route::prefix('classes')->name('admin.academic.classes.')->group(function () {
        Route::get('/', [ClassesController::class, 'index'])->name('index');
        Route::get('/create', [ClassesController::class, 'create'])->name('create');
        Route::post('/', [ClassesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ClassesController::class, 'edit'])->name('edit');
        Route::get('/{id}/show', [ClassesController::class, 'show'])->name('show');
        Route::put('/{id}', [ClassesController::class, 'update'])->name('update');
        Route::delete('/{id}', [ClassesController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [ClassesController::class, 'restore'])->name('restore');
    });

    Route::prefix('sections')->name('admin.academic.sections.')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('index');
        Route::post('/', [SectionController::class, 'store'])->name('store');
        Route::put('/{id}', [SectionController::class, 'update'])->name('update');
        Route::get('/{id}/edit', [SectionController::class, 'edit'])->name('edit');
        Route::get('/create', [SectionController::class, 'create'])->name('create');
        Route::get('/{id}', [SectionController::class, 'show'])->name('show');
        Route::delete('/{id}', [SectionController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [SectionController::class, 'restore'])->name('restore');
    });
    Route::get('/get-sections/{class_id}', [SectionController::class, 'getSectionsByClass']);

    Route::prefix('subjects')->name('admin.academic.subjects.')->group(function () {
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

    Route::prefix('timetable')->name('admin.timetable.')->group(function () {
        Route::get('/', [TimetableController::class, 'index'])->name('index');
        Route::get('/create', [TimetableController::class, 'create'])->name('create');
        Route::post('/', [TimetableController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TimetableController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TimetableController::class, 'update'])->name('update');
        Route::delete('/{id}', [TimetableController::class, 'destroy'])->name('destroy');
    });
    Route::get('create_schedule', [TimetableController::class, 'create_schedule'])->name('admin.timetable.create.schedule');
    Route::post('store_schedule', [TimetableController::class, 'store_schedule'])->name('admin.timetable.store.schedule');
    Route::post('update_schedule', [TimetableController::class, 'update_schedule'])->name('admin.timetable.update.schedule');
    Route::get('/admin/get-teachers-by-subject', [TimetableController::class, 'getTeachersBySubject'])->name('admin.getTeachersBySubject');

    Route::prefix('attendance')->group(function () {
        Route::get('/', [SessionAttendanceController::class, 'index'])->name('admin.attendance.index');
        Route::get('/history', [SessionAttendanceController::class, 'history'])->name('admin.attendance.history');
        Route::get('/take', [SessionAttendanceController::class, 'create'])->name('admin.attendance.create');
        Route::get('/get-sections', [SessionAttendanceController::class, 'getSections'])->name('attendance.get-sections');
        Route::get('/get-subjects', [SessionAttendanceController::class, 'getSubjects'])->name('attendance.get-subjects');
        Route::get('/get-students', [SessionAttendanceController::class, 'getStudents'])->name('attendance.get-students');
        Route::post('/save', [SessionAttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/{session}', [SessionAttendanceController::class, 'show'])->name('admin.attendance.show')->whereNumber('session');
        Route::get('/{session}/edit', [SessionAttendanceController::class, 'edit'])->name('admin.attendance.edit')->whereNumber('session');
        Route::put('/{session}', [SessionAttendanceController::class, 'update'])->name('admin.attendance.update')->whereNumber('session');
    });
    Route::get('/check-classes', [SessionAttendanceController::class, 'checkClasses'])->name('check-classes');
    Route::get('/attendance/trends', [SessionAttendanceController::class, 'getAttendanceTrends']);

    Route::get('/fees', fn () => response()->json(['message' => 'Fees module']))->name('fees.index');
    Route::get('/exams', fn () => response()->json(['message' => 'Exams module']))->name('exams.index');
    Route::get('/library', fn () => response()->json(['message' => 'Library module']))->name('library.index');
    Route::get('/inventory', fn () => response()->json(['message' => 'Inventory module']))->name('inventory.index');
    Route::get('/notices', fn () => response()->json(['message' => 'Notices module']))->name('notices.index');
    Route::get('/holidays', fn () => response()->json(['message' => 'Holidays module']))->name('holidays.index');
    Route::get('/reports', fn () => response()->json(['message' => 'Reports module']))->name('reports.index');
    Route::get('/branch-settings', fn () => response()->json(['message' => 'Branch settings']))->name('branch.settings');
    Route::get('/notifications', fn () => response()->json(['message' => 'Notifications']))->name('notifications.index');

    Route::resource('user', UserController::class);
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:teacher'])->group(function () {
    Route::get('/teacher/timetable', [TimetableController::class, 'index'])->name('teacher.timetable');
    Route::get('/teacher/attendance', [SessionAttendanceController::class, 'create'])->name('teacher.attendance');
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:student'])->group(function () {
    Route::get('/student/timetable', [TimetableController::class, 'index'])->name('student.timetable');
    Route::get('/student/attendance', fn () => response()->json(['message' => 'Student attendance']))->name('student.attendance');
    Route::get('/student/results', fn () => response()->json(['message' => 'Student results']))->name('student.results');
    Route::get('/student/fees', fn () => response()->json(['message' => 'Student fees']))->name('student.fees');
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:parent'])->group(function () {
    Route::get('/parent/children', fn () => response()->json(['message' => 'Parent children']))->name('parent.children');
    Route::get('/parent/attendance', fn () => response()->json(['message' => 'Parent attendance']))->name('parent.attendance');
    Route::get('/parent/results', fn () => response()->json(['message' => 'Parent results']))->name('parent.results');
    Route::get('/parent/fees', fn () => response()->json(['message' => 'Parent fees']))->name('parent.fees');
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:accountant'])->group(function () {
    Route::get('/accountant/fees', fn () => response()->json(['message' => 'Accountant fees']))->name('accountant.fees');
    Route::get('/accountant/payments', fn () => response()->json(['message' => 'Accountant payments']))->name('accountant.payments');
    Route::get('/accountant/reports', fn () => response()->json(['message' => 'Accountant reports']))->name('accountant.reports');
});
