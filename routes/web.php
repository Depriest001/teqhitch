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
use App\Http\Controllers\Admin\TopicController; 
use App\Http\Controllers\Admin\PapersController;
use App\Http\Controllers\Admin\TopicPaymentController;
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
use App\Http\Controllers\User\SearchTopicController;


// ----------------------
// Public Pages
// ----------------------
Route::controller(\App\Http\Controllers\View\ViewController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/services', 'services')->name('services');
    Route::get('/services/{slug}', 'serviceDetail')->name('service.show');
});

// Flutterwave webhook (topic payment)
Route::post('flutterwave/webhook', [SearchTopicController::class, 'webhook']);
Route::post('course/flutterwave/webhook', [CourseController::class, 'webhook']);

Route::controller(AuthController::class)->group(function () {

    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login')->name('login.submit');

    Route::get('admin/login', 'AdminLoginForm')->name('admin.login');
    Route::post('admin/login', 'adminLogin')->name('admin.login.submit');

    Route::get('register', 'showRegisterForm')->name('register');
    Route::post('register', 'register')->name('register.submit');

    Route::get('forgot-password', 'showForgotPasswordForm')->name('forgot.password');
    Route::post('logout', 'logout')->name('logout');
});


// =====================
// ADMIN ROUTES
// ====================
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'profile'])->name('profile');
            Route::patch('update', [AdminDashboardController::class, 'update'])->name('profile.update');
            Route::put('password', [AdminDashboardController::class, 'updatePassword'])->name('profile.password.update');
        });

        // System Settings
        Route::prefix('system-settings')->name('system.settings.')->group(function () {
            Route::get('/', [SystemSettingController::class, 'edit'])->name('edit');
            Route::patch('/', [SystemSettingController::class, 'updateinfo'])->name('update');
            Route::patch('branding', [SystemSettingController::class, 'updateBranding'])->name('branding');
            Route::patch('about', [SystemSettingController::class, 'updateAbout'])->name('about');
        });

        Route::patch('email-settings', [SystemSettingController::class, 'updatemail'])
            ->name('email.settings.update');

        // Suspensions
        Route::patch('admins/{admin}/suspend', [AdminController::class, 'suspend'])->name('admins.suspend');
        Route::patch('instructors/{instructor}/suspend', [AdminInstructorController::class, 'suspend'])->name('instructors.suspend');
        Route::patch('students/{student}/suspend', [AdminStudentController::class, 'suspend'])->name('students.suspend');

        // Courses
        Route::patch('courses/{course}/toggle-status', [AdminCoursesController::class, 'toggleStatus'])
            ->name('courses.toggleStatus');

        // Transactions
        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::patch('{transaction}/mark-paid', [AdminTransactionController::class, 'markPaid'])->name('markPaid');
            Route::patch('{transaction}/refund', [AdminTransactionController::class, 'refund'])->name('refund');
        });

        // Papers
        Route::prefix('papers')->name('papers.')->group(function () {
            Route::post('store', [PapersController::class, 'store'])->name('store');
            Route::get('download/{id}', [PapersController::class, 'download'])->name('download');
            Route::get('download-software/{id}', [PapersController::class, 'downloadSoftware'])->name('downloadSoftware');
        });

        // Topic Payments
        Route::get('topic-payments', [TopicPaymentController::class, 'index'])->name('topic-payments.index');
        Route::get('topic-payments/{id}', [TopicPaymentController::class, 'show'])->name('topic-payments.show');
        Route::post('topic-payments/{id}/status', [TopicPaymentController::class, 'updateStatus'])
            ->name('topic-payments.updateStatus');

        // Topic Payment Settings
        Route::prefix('topic-payment-settings')->name('topic-payment-settings.')->group(function () {
            Route::get('/', [TopicPaymentController::class, 'settingsIndex'])->name('index');
            Route::post('/', [TopicPaymentController::class, 'settingsStore'])->name('store');
            Route::put('{setting}', [TopicPaymentController::class, 'settingsUpdate'])->name('update');
            Route::delete('{setting}', [TopicPaymentController::class, 'destroy'])->name('destroy');
        });

        Route::delete('topic-payment/{id}', [TopicPaymentController::class, 'paymentDestroy'])
            ->name('topic-payment.destroy');

        // Resources
        Route::resources([
            'admins' => AdminController::class,
            'courses' => AdminCoursesController::class,
            'student' => AdminStudentController::class,
            'instructor' => AdminInstructorController::class,
            'transaction' => AdminTransactionController::class,
            'announcement' => AdminAnnouncementController::class,
            'topics' => TopicController::class,
        ]);
    });

// =====================
// STAFF ROUTES
// =====================
Route::prefix('staff')
    ->name('staff.')
    ->middleware(['auth', CheckInstructor::class])
    ->group(function () {

        Route::get('/', [StaffDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('profile')->group(function () {
            Route::get('/', [StaffDashboardController::class, 'profile'])->name('profile');
            Route::patch('update', [StaffDashboardController::class, 'updateProfile'])->name('profile.update');
            Route::put('password', [StaffDashboardController::class, 'updatePassword'])->name('profile.password');
        });

        Route::get('courses/analytics', [StaffCourseController::class, 'analytics'])
            ->name('courses.analytics');

        Route::get('announcement/view', [StaffAnnouncementController::class, 'view'])
            ->name('announcement.view');

        // Modules
        Route::post('course/{course}/module', [StaffCourseController::class, 'storemodule'])
            ->name('course.module.store');

        Route::get('course/{course}/module/{module}/edit', [StaffCourseController::class, 'editmodule'])
            ->name('module.edit');

        Route::put('course/{course}/module/{module}', [StaffCourseController::class, 'updatemodule'])
            ->name('module.update');

        Route::delete('course/{course}/module/{module}', [StaffCourseController::class, 'destroymodule'])
            ->name('module.destroy');

        // Assignment grading
        Route::post('assignments/{assignment}/submissions/{submission}/grade',
            [StaffAssignmentController::class, 'storeGrade'])
            ->name('assignment.grade.store');

        Route::get('assignments/{assignment}/submissions/{submission}',
            [StaffAssignmentController::class, 'grade'])
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
    ->name('user.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::get('enroll', [CourseController::class, 'view'])->name('courses.enroll');

        Route::get('activities', [UserDashboardController::class, 'activities'])->name('activities');
        Route::get('certificates', [UserDashboardController::class, 'certificate'])->name('certificates');

        // Profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [UserDashboardController::class, 'profile'])->name('profile');
            Route::patch('/', [UserDashboardController::class, 'update'])->name('profile.update');
            Route::put('password', [UserDashboardController::class, 'changePassword'])->name('password.update');
        });

        // Course Purchase
        Route::get('student/course/{course}/buy', [CourseController::class, 'buyCourse'])
            ->name('student.course.buy');

        Route::get('course/{course}/buy', [CourseController::class, 'buyCourse'])
            ->name('course.buy');

        Route::get('course/{course}/callback', [CourseController::class, 'callback'])
            ->name('course.callback');

        Route::post('course/payment-webhook', [CourseController::class, 'paymentWebhook'])
            ->name('course.webhook');

        Route::post('module/{module}/complete',
            [ModuleProgressController::class, 'complete'])
            ->name('module.complete');

        // Announcements
        Route::get('announcements', [AnnouncementController::class, 'index'])
            ->name('announcement.index');

        Route::post('announcements/{announcement}/read',
            [AnnouncementController::class, 'markAsRead'])
            ->name('announcement.read');

        Route::get('assignment/grade', [AssignmentController::class, 'grade'])
            ->name('assignment.grade');

        Route::resource('courses', CourseController::class);
        Route::resource('assignment', AssignmentController::class);
        Route::resource('certificate', CertificateController::class);

        // Topics
        Route::prefix('topics')->name('searchTopics.')->group(function () {
            Route::get('/', [SearchTopicController::class, 'index'])->name('index');
            Route::get('generate', [SearchTopicController::class, 'create'])->name('create');
            Route::post('generate', [SearchTopicController::class, 'generate'])->name('generate');
            Route::post('use-multiple', [SearchTopicController::class, 'useTopic'])->name('useMultiple');
            Route::post('approve', [SearchTopicController::class, 'submitTopic'])->name('approve');
            Route::get('{id}', [SearchTopicController::class, 'show'])->name('show');
        });

        // Topic Payment
        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('failed', [CourseController::class, 'failed'])->name('failed');
            Route::get('processing', fn() => view('user.searchTopics.processing'))->name('processing');
            Route::post('{slug}/initialize', [SearchTopicController::class, 'initialize'])->name('initialize');
            Route::get('{slug}/{user_topic_id?}', [SearchTopicController::class, 'topicShow'])->name('show');
            Route::get('check', [SearchTopicController::class, 'check'])->name('check');
        });
});