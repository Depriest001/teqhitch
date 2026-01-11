<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View\ViewController;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Middleware\CheckInstructor;

// admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCoursesController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminInstructorController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\SystemSettingController;
// staff
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\StaffCourseController;
use App\Http\Controllers\Staff\StaffStudentController;
use App\Http\Controllers\Staff\StaffAssignmentController;
use App\Http\Controllers\Staff\StaffAnnouncementController;
// student
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\AssignmentController;
use App\Http\Controllers\User\CertificateController;
use App\Http\Controllers\User\AnnouncementController;
use App\Http\Controllers\User\ModuleProgressController;


// ----------------------
// Public Pages
// ----------------------
Route::controller(ViewController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/services', 'services')->name('services');
    
    // Dynamic service detail page
    Route::get('/services/{slug}', 'serviceDetail')->name('service.show');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::get('/admin/login', 'AdminLoginForm')->name('admin.login');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('forgot.password');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
});


// =====================
// ADMIN ROUTES
// ====================
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth:admin'])
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [AdminDashboardController::class, 'profile'])->name('profile');
        Route::get('system-setting', [SystemSettingController::class, 'edit'])->name('system.setting');

        Route::patch('/admin/profile/update', [AdminDashboardController::class, 'update'])->name('profile.update');
        Route::put('/admin/profile/password', [AdminDashboardController::class, 'updatePassword'])->name('profile.password.update');
        
        Route::patch('/system-settings', [SystemSettingController::class, 'updateinfo'])
            ->name('system.settings.update');
        Route::patch('/system-settings/branding', [SystemSettingController::class, 'updateBranding'])
            ->name('system.settings.branding.update');
        Route::patch('/email-settings', [SystemSettingController::class, 'updatemail'])
            ->name('email.settings.updatemail');
        Route::patch('/system-settings/about', [SystemSettingController::class, 'updateAbout'])
            ->name('system.settings.about.update');

        Route::patch('/{admin}/suspend', [AdminController::class, 'suspend'])
            ->name('admins.suspend');
        Route::patch('instructor/{instructor}/suspend', [AdminInstructorController::class, 'suspend'])
            ->name('instructor.suspend');
        Route::patch('student/{student}/suspend', [AdminStudentController::class, 'suspend'])
            ->name('student.suspend');
        
        Route::patch('courses/{course}/toggle-status', [AdminCoursesController::class, 'toggleStatus'])
            ->name('courses.toggleStatus');

        Route::patch('transactions/{transaction}/mark-paid', [AdminTransactionController::class, 'markPaid'])
            ->name('transactions.markPaid');

        Route::patch('transactions/{transaction}/refund', [AdminTransactionController::class, 'refund'])
            ->name('transactions.refund');

        Route::resource('admins', AdminController::class);
        Route::resource('courses', AdminCoursesController::class);
        Route::resource('student', AdminStudentController::class);
        Route::resource('instructor', AdminInstructorController::class);
        Route::resource('transaction', AdminTransactionController::class);
        Route::resource('announcement', AdminAnnouncementController::class);

    });


// =====================
// STAFF ROUTES
// =====================
Route::prefix('staff')
    ->as('staff.')
    ->middleware(['auth', CheckInstructor::class])
    ->group(function () {

        Route::get('/', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [StaffDashboardController::class, 'profile'])->name('profile');
        Route::get('courses/analytics', [StaffCourseController::class, 'analytics'])->name('courses.analytics');
        Route::get('announcement/view', [StaffAnnouncementController::class, 'view'])->name('announcement.view');

        Route::patch('/profile/update', [StaffDashboardController::class, 'updateProfile'])
            ->name('profile.update');

        Route::put('/profile/change-password', [StaffDashboardController::class, 'updatePassword'])
            ->name('profile.password');

        Route::post('/staff/course/{course}/module', [StaffCourseController::class, 'storemodule'])->name('course.module.store');
        
        Route::get('course/{course}/module/{module}/edit', [StaffCourseController::class, 'editmodule'])
            ->name('module.edit');
        Route::put('course/{course}/module/{module}', [StaffCourseController::class, 'updatemodule'])
            ->name('module.update');

        Route::delete('course/{course}/module/{module}', [StaffCourseController::class, 'destroymodule'])
            ->name('module.destroy');
        
        Route::post('courses/{course}/assignments', [StaffAssignmentController::class, 'storeAssignment'])
            ->name('course.assignment.store');
        
        Route::post('/assignments/{assignment}/submissions/{submission}/grade',[StaffAssignmentController::class, 'storeGrade'])
            ->name('assignment.grade.store');
            
         Route::get('/assignments/{assignment}/submissions/{submission}',[StaffAssignmentController::class, 'grade'])
            ->name('assignment.grade');
            

        Route::resource('courses', StaffCourseController::class);
        Route::resource('student', StaffStudentController::class);
        Route::resource('assignment', StaffAssignmentController::class);
        Route::resource('announcement', StaffAnnouncementController::class);

    });


// =====================
// USER ROUTES
// =====================
Route::prefix('user')
    ->as('user.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
        Route::get('/activities', [UserDashboardController::class, 'activities'])->name('activities');
        Route::get('/certificates', [UserDashboardController::class, 'certificate'])->name('certificates');

        Route::get('enroll', [CourseController::class, 'view'])->name('courses.enroll');
        Route::get('payment/failed', [CourseController::class, 'failed'])->name('payment.failed');

        // Route to handle "buy now" (redirect to payment or enrollment)
        Route::get('/student/course/{course}/buy', [CourseController::class, 'buyCourse'])
            ->name('student.course.buy');

        Route::get('/course/{course}/buy', [CourseController::class, 'buyCourse'])
            ->name('course.buy');

        Route::get('/course/{course}/callback', [CourseController::class, 'callback'])
            ->name('course.callback');
        // routes/web.php
        Route::post('/user/course/payment-webhook', [CourseController::class, 'paymentWebhook']);

        Route::post('/user/module/{module}/complete', 
                [ModuleProgressController::class, 'complete']
            )->name('module.complete');

        Route::get('/announcements', [AnnouncementController::class, 'index'])
            ->name('announcement.index');

        Route::post('/announcements/{announcement}/read', [AnnouncementController::class, 'markAsRead'])
            ->name('announcement.read');
                // Courses
        Route::resource('courses', CourseController::class);

        Route::patch('/profile', [UserDashboardController::class, 'update'])
            ->name('profile.update');

        Route::put('/change-password', [UserDashboardController::class, 'changePassword'])
            ->name('password.update');

        // Assignment
        Route::get('/assignment/grade', [AssignmentController::class, 'grade'])->name('assignment.grade');
        Route::resource('assignment', AssignmentController::class);

        // Certificates
        Route::resource('certificate', CertificateController::class);
    });
