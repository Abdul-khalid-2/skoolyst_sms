<?php

use App\Http\Controllers\Admin\AcademicSetupController;
use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SubjectTeacherController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\UserController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Student\ResultController as StudentResultController;
use App\Http\Controllers\Student\FeeController as StudentFeeController;
use App\Http\Controllers\Student\BookIssueController as StudentBookIssueController;
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;
use App\Http\Controllers\Parent\ChildrenController as ParentChildrenController;
use App\Http\Controllers\Parent\AttendanceController as ParentAttendanceController;
use App\Http\Controllers\Parent\ResultController as ParentResultController;
use App\Http\Controllers\Parent\FeeController as ParentFeeController;
use App\Http\Controllers\Parent\BookIssueController as ParentBookIssueController;
use App\Http\Controllers\Parent\NoticeController as ParentNoticeController;
use App\Http\Controllers\Accountant\DashboardController as AccountantDashboardController;
use App\Http\Controllers\Accountant\FeeController as AccountantFeeController;
use App\Http\Controllers\Accountant\PaymentController as AccountantPaymentController;
use App\Http\Controllers\Accountant\ReportController as AccountantReportController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\ExamController as TeacherExamController;
use App\Http\Controllers\Teacher\ExamResultController as TeacherExamResultController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\SubjectController as TeacherSubjectController;
use App\Http\Controllers\Teacher\TimetableController as TeacherTimetableController;
use App\Http\Controllers\Teacher\ReportController as TeacherReportController;
use App\Http\Controllers\Student\TimetableController as StudentTimetableController;
use App\Http\Controllers\Student\NoticeController as StudentNoticeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Attendance\AttendanceController as SessionAttendanceController;
use App\Http\Controllers\Admin\BranchController as AdminBranchController;
use App\Http\Controllers\Admin\BranchSettingsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SidebarSettingController;
use App\Http\Controllers\Platform\PlatformSettingController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Holiday\HolidayController;
use App\Http\Controllers\Notice\NoticeController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Inventory\InventoryItemController;
use App\Http\Controllers\Inventory\InventoryTransactionController;
use App\Http\Controllers\Library\LibraryController;
use App\Http\Controllers\Library\BookController;
use App\Http\Controllers\Library\BookIssueController;
use App\Http\Controllers\Exams\ExamController;
use App\Http\Controllers\Exams\ExamScheduleController;
use App\Http\Controllers\Exams\ExamResultController;
use App\Http\Controllers\Fees\FeesController;
use App\Http\Controllers\Fees\FeeCategoryController;
use App\Http\Controllers\Fees\FeeStructureController;
use App\Http\Controllers\Fees\FeePaymentController;
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
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/profile', [ProfileController::class, 'redirect'])->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('branches', AdminBranchController::class)->except(['show']);

    Route::get('/sidebar-settings', [SidebarSettingController::class, 'index'])->name('sidebar.index');
    Route::put('/sidebar-settings/{sidebarSetting}', [SidebarSettingController::class, 'update'])->name('sidebar.update');

    // ── Platform Settings (roles, permissions, feature gates) ────────────────
    Route::prefix('platform-settings')->name('platform.')->group(function () {
        Route::get('/',                  [PlatformSettingController::class, 'index'])->name('index');
        Route::get('/features',          [PlatformSettingController::class, 'features'])->name('features');
        Route::put('/features',          [PlatformSettingController::class, 'featuresUpdate'])->name('features.update');
        Route::get('/permissions',       [PlatformSettingController::class, 'permissions'])->name('permissions');
        Route::put('/permissions',       [PlatformSettingController::class, 'permissionsUpdate'])->name('permissions.update');
        Route::get('/roles',             [PlatformSettingController::class, 'roles'])->name('roles');
    });
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:super-admin|admin'])->group(function () {
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

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
    Route::get('/show_parent/{id}', [ParentController::class, 'show'])->name('admin.show.parent');
    Route::get('/edit_parent/{id}', [ParentController::class, 'edit'])->name('admin.edit.parent');
    Route::put('/edit_parent/{id}', [ParentController::class, 'update'])->name('admin.update.parent');
    Route::delete('/destroy_parent/{id}', [ParentController::class, 'destroy'])->name('admin.destroy.parent');

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
    Route::get('/show_teacher/{id?}', [TeacherController::class, 'show'])->name('admin.show.teacher');
    Route::put('/edit_teacher/{id?}', [TeacherController::class, 'update'])->name('admin.update.teacher');
    Route::delete('/destroy_teacher', [TeacherController::class, 'destroy'])->name('admin.destroy.teacher');
    Route::post('/teacher/status-update', [TeacherController::class, 'updateStatus'])->name('teacher.update.status');

    Route::get('/academic-setup', [AcademicSetupController::class, 'index'])->name('admin.academic.setup');

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
    Route::post('/subjects/assign-class-subject', [SubjectController::class, 'assignClassSubjectStore'])->name('admin.academic.subjects.assign_class_subject');

    // Assign a teacher to each subject of a class section.
    Route::get('/subject-teacher-assign', [SubjectTeacherController::class, 'index'])->name('admin.academic.subjects.section_teacher');
    Route::get('/subject-teacher-assign/sections/{classId}', [SubjectTeacherController::class, 'getSections'])->name('admin.academic.subjects.section_teacher.sections');
    Route::get('/subject-teacher-assign/subjects', [SubjectTeacherController::class, 'getSubjects'])->name('admin.academic.subjects.section_teacher.subjects');
    Route::post('/subject-teacher-assign', [SubjectTeacherController::class, 'store'])->name('admin.academic.subjects.section_teacher.store');

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

    // ── Fees Management ─────────────────────────────────────────
    Route::prefix('fees')->name('fees.')->group(function () {
        Route::get('/',                         [FeesController::class,         'index'])->name('index');
        Route::resource('categories',           FeeCategoryController::class)->except(['show']);
        Route::resource('structures',           FeeStructureController::class)->except(['show']);
        Route::get('payments',                  [FeePaymentController::class,   'index'])->name('payments.index');
        Route::get('payments/students',         [FeePaymentController::class,   'getStudentsByClass'])->name('payments.students');
        Route::get('payments/create',           [FeePaymentController::class,   'create'])->name('payments.create');
        Route::post('payments',                 [FeePaymentController::class,   'store'])->name('payments.store');
        Route::get('payments/{payment}',        [FeePaymentController::class,   'show'])->name('payments.show');
        Route::delete('payments/{payment}',     [FeePaymentController::class,   'destroy'])->name('payments.destroy');
    });
    // ── Exams ────────────────────────────────────────────────────
    Route::prefix('exams')->name('exams.')->group(function () {
        Route::get('/',                                          [ExamController::class,         'index'])->name('index');
        Route::get('/create',                                    [ExamController::class,         'create'])->name('create');
        Route::post('/',                                         [ExamController::class,         'store'])->name('store');
        Route::get('/{exam}',                                    [ExamController::class,         'show'])->name('show');
        Route::get('/{exam}/edit',                               [ExamController::class,         'edit'])->name('edit');
        Route::put('/{exam}',                                    [ExamController::class,         'update'])->name('update');
        Route::delete('/{exam}',                                 [ExamController::class,         'destroy'])->name('destroy');

        // Schedule
        Route::get('/{exam}/schedule/create',                    [ExamScheduleController::class, 'create'])->name('schedule.create');
        Route::get('/{exam}/schedule/subjects',                  [ExamScheduleController::class, 'getSubjects'])->name('schedule.subjects');
        Route::post('/{exam}/schedule',                          [ExamScheduleController::class, 'store'])->name('schedule.store');
        Route::get('/{exam}/schedule/{schedule}/edit',           [ExamScheduleController::class, 'edit'])->name('schedule.edit');
        Route::put('/{exam}/schedule/{schedule}',                [ExamScheduleController::class, 'update'])->name('schedule.update');
        Route::delete('/{exam}/schedule/{schedule}',             [ExamScheduleController::class, 'destroy'])->name('schedule.destroy');

        // Results
        Route::get('/{exam}/results',                            [ExamResultController::class,   'index'])->name('results.index');
        Route::get('/{exam}/results/enter',                      [ExamResultController::class,   'enter'])->name('results.enter');
        Route::post('/{exam}/results',                           [ExamResultController::class,   'store'])->name('results.store');
    });
    // ── Library ──────────────────────────────────────────────────
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/',                                  [LibraryController::class,   'index'])->name('index');

        // Books
        Route::get('/books',                             [BookController::class,      'index'])->name('books.index');
        Route::get('/books/create',                      [BookController::class,      'create'])->name('books.create');
        Route::post('/books',                            [BookController::class,      'store'])->name('books.store');
        Route::get('/books/{book}',                      [BookController::class,      'show'])->name('books.show');
        Route::get('/books/{book}/edit',                 [BookController::class,      'edit'])->name('books.edit');
        Route::put('/books/{book}',                      [BookController::class,      'update'])->name('books.update');
        Route::delete('/books/{book}',                   [BookController::class,      'destroy'])->name('books.destroy');

        // Issues
        Route::get('/issues',                            [BookIssueController::class, 'index'])->name('issues.index');
        Route::get('/issues/create',                     [BookIssueController::class, 'create'])->name('issues.create');
        Route::post('/issues',                           [BookIssueController::class, 'store'])->name('issues.store');
        Route::get('/issues/{issue}',                    [BookIssueController::class, 'show'])->name('issues.show');
        Route::put('/issues/{issue}/return',             [BookIssueController::class, 'returnBook'])->name('issues.return');
    });
    // ── Inventory ────────────────────────────────────────────────
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/',                          [InventoryController::class,            'index'])->name('index');

        // Items
        Route::get('/items',                     [InventoryItemController::class,        'index'])->name('items.index');
        Route::get('/items/create',              [InventoryItemController::class,        'create'])->name('items.create');
        Route::post('/items',                    [InventoryItemController::class,        'store'])->name('items.store');
        Route::get('/items/{item}',              [InventoryItemController::class,        'show'])->name('items.show');
        Route::get('/items/{item}/edit',         [InventoryItemController::class,        'edit'])->name('items.edit');
        Route::put('/items/{item}',              [InventoryItemController::class,        'update'])->name('items.update');
        Route::delete('/items/{item}',           [InventoryItemController::class,        'destroy'])->name('items.destroy');

        // Stock transactions
        Route::get('/transactions',              [InventoryTransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/create',       [InventoryTransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions',             [InventoryTransactionController::class, 'store'])->name('transactions.store');
    });
    // ── Notices ──────────────────────────────────────────────────
    Route::resource('notices', NoticeController::class);
    // ── Holidays ─────────────────────────────────────────────────
    Route::resource('holidays', HolidayController::class);
    // ── Reports ──────────────────────────────────────────────────
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/',           [ReportController::class, 'index'])->name('index');
        Route::get('/students',   [ReportController::class, 'students'])->name('students');
        Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
        Route::get('/fees',       [ReportController::class, 'fees'])->name('fees');
        Route::get('/exams',      [ReportController::class, 'exams'])->name('exams');
        Route::get('/library',    [ReportController::class, 'library'])->name('library');
        Route::get('/inventory',  [ReportController::class, 'inventory'])->name('inventory');
    });
    Route::get('/branch-settings', [BranchSettingsController::class, 'edit'])->name('branch.settings');
    Route::put('/branch-settings', [BranchSettingsController::class, 'update'])->name('branch.settings.update');
    Route::resource('user', UserController::class);
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:teacher'])->group(function () {
    Route::get('/teacher/profile', [TeacherProfileController::class, 'index'])->name('teacher.profile');
    Route::get('/teacher/profile/edit', [TeacherProfileController::class, 'edit'])->name('teacher.profile.edit');
    Route::patch('/teacher/profile', [TeacherProfileController::class, 'update'])->name('teacher.profile.update');
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/students', [TeacherStudentController::class, 'index'])->name('teacher.students');
    Route::get('/teacher/subjects', [TeacherSubjectController::class, 'index'])->name('teacher.subjects');
    Route::get('/teacher/timetable', [TeacherTimetableController::class, 'index'])->name('teacher.timetable');
    Route::get('/teacher/reports', [TeacherReportController::class, 'index'])->name('teacher.reports');

    Route::prefix('teacher/attendance')->name('teacher.attendance.')->group(function () {
        Route::get('/get-sections', [TeacherAttendanceController::class, 'getSections'])->name('sections');
        Route::get('/get-students', [TeacherAttendanceController::class, 'getStudents'])->name('students');
        Route::get('/check-classes', [TeacherAttendanceController::class, 'checkClasses'])->name('check');
        Route::post('/save', [TeacherAttendanceController::class, 'store'])->name('store');
        Route::get('/{session}', [TeacherAttendanceController::class, 'show'])->name('show')->whereNumber('session');
    });
    Route::get('/teacher/attendance', [TeacherAttendanceController::class, 'create'])->name('teacher.attendance');

    Route::prefix('teacher/exams')->name('teacher.exams.')->group(function () {
        Route::prefix('tests')->name('tests.')->group(function () {
            Route::get('/', [TeacherExamController::class, 'index'])->name('index');
            Route::get('/create', [TeacherExamController::class, 'create'])->name('create');
            Route::post('/', [TeacherExamController::class, 'store'])->name('store');
            Route::get('/subjects', [TeacherExamController::class, 'getSubjects'])->name('subjects');
            Route::get('/{exam}', [TeacherExamController::class, 'show'])->name('show');
        });

        Route::prefix('marks')->name('marks.')->group(function () {
            Route::get('/', [TeacherExamResultController::class, 'index'])->name('index');
            Route::get('/sections', [TeacherExamResultController::class, 'getSections'])->name('sections');
            Route::get('/subjects', [TeacherExamResultController::class, 'getSubjects'])->name('subjects');
            Route::get('/{exam}/students', [TeacherExamResultController::class, 'getStudents'])->name('students');
            Route::get('/{exam}/enter', [TeacherExamResultController::class, 'enter'])->name('enter');
            Route::post('/{exam}', [TeacherExamResultController::class, 'store'])->name('store');
        });
    });
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:student'])->group(function () {
    Route::get('/student/profile', [StudentProfileController::class, 'index'])->name('student.profile');
    Route::get('/student/profile/edit', [StudentProfileController::class, 'edit'])->name('student.profile.edit');
    Route::patch('/student/profile', [StudentProfileController::class, 'update'])->name('student.profile.update');
    Route::get('/student/timetable', [StudentTimetableController::class, 'index'])->name('student.timetable');
    Route::get('/student/notices', [StudentNoticeController::class, 'index'])->name('student.notices');
    Route::get('/student/attendance', [StudentAttendanceController::class, 'index'])->name('student.attendance');
    Route::get('/student/results', [StudentResultController::class, 'index'])->name('student.results');
    Route::get('/student/results/{exam}', [StudentResultController::class, 'show'])->name('student.results.show');
    Route::get('/student/fees', [StudentFeeController::class, 'index'])->name('student.fees');
    Route::get('/student/fees/{fee}', [StudentFeeController::class, 'show'])->name('student.fees.show');
    Route::get('/student/books', [StudentBookIssueController::class, 'index'])->name('student.books');
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/children', [ParentChildrenController::class, 'index'])->name('children');
    Route::get('/children/{student}/attendance', [ParentAttendanceController::class, 'index'])->name('children.attendance');
    Route::get('/children/{student}/results', [ParentResultController::class, 'index'])->name('children.results');
    Route::get('/children/{student}/results/{exam}', [ParentResultController::class, 'show'])->name('children.results.show');
    Route::get('/fees', [ParentFeeController::class, 'index'])->name('fees');
    Route::get('/books', [ParentBookIssueController::class, 'index'])->name('books');
    Route::get('/notices', [ParentNoticeController::class, 'index'])->name('notices');
});

Route::middleware(['auth', 'verified', 'scope.branch', 'role:accountant'])->prefix('accountant')->name('accountant.')->group(function () {
    Route::get('/dashboard', [AccountantDashboardController::class, 'index'])->name('dashboard');
    Route::get('/fees', [AccountantFeeController::class, 'index'])->name('fees');
    Route::get('/payments', [AccountantPaymentController::class, 'index'])->name('payments');
    Route::get('/reports', [AccountantReportController::class, 'index'])->name('reports');
});
