<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\View\ViewController;
use App\Http\Controllers\View\SubscriberController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Middleware\CheckInstructor;
use App\Http\Controllers\View\ViewTopicController;
use App\Http\Controllers\View\SiwesApplicationController;

// admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCoursesController;
use App\Http\Controllers\Admin\AdminCertificateController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminInstructorController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\TopicController; 
use App\Http\Controllers\Admin\PapersController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewslettersController;
use App\Http\Controllers\Admin\TestimonyController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\EnrollmentApplicationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AdminSiwesApplicationController;
use App\Http\Controllers\Admin\SiwesTrackController;

// staff
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\StaffCourseController;
use App\Http\Controllers\Staff\StaffStudentController;
use App\Http\Controllers\Staff\StaffAssignmentController;
use App\Http\Controllers\Staff\StaffAnnouncementController;

// student
use App\Http\Controllers\Student\StudentController;

// ----------------------
// Public Pages
// ----------------------
Route::controller(\App\Http\Controllers\View\ViewController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/courses', 'services')->name('services');
    Route::get('/news', 'news')->name('news');
    Route::get('/products', 'products')->name('products');
    Route::get('/news/{news}', 'newsdetail')->name('news.detail');
    Route::get('/enroll', 'enroll')->name('enroll');
    Route::post('/enroll/store', 'storeEnroll')->name('enroll.store');
});

/*
|--------------------------------------------------------------------------
| SIWES / IT Placement — Teqhitch ICT Academy
|--------------------------------------------------------------------------
| Merge these routes into your existing routes/web.php
*/

Route::prefix('siwes')->name('siwes.')->group(function () {
    Route::get('/apply', [SiwesApplicationController::class, 'create'])->name('apply');
    Route::post('/apply', [SiwesApplicationController::class, 'store'])->name('store');
    Route::get('/payment/{application:reference}', [SiwesApplicationController::class, 'payment'])->name('payment');
    Route::get('/payment/{application:reference}/status', [SiwesApplicationController::class, 'status'])->name('payment.status');
    Route::get('/payment/{application:reference}/success', [SiwesApplicationController::class, 'success'])->name('payment.success');
});


// Strowallet posts here — must stay outside CSRF protection (see notes below).
Route::post('/webhooks/strowallet', [SiwesApplicationController::class, 'webhook'])->name('siwes.webhook');

Route::get('/topics', [ViewTopicController::class, 'index'])->name('topics.index');
Route::get('/topics/filter', [ViewTopicController::class, 'filter'])->name('topics.filter');

// subscriber
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscriber.store');
Route::get('/verify/{token}', [SubscriberController::class, 'verify'])->name('subscriber.verify');
Route::get('/unsubscribe/{email}', [SubscriberController::class, 'unsubscribe'])->name('subscriber.unsubscribe');
Route::get('/thank-you', function () {
    if (!session()->has('message')) {
        return redirect('/');
    }
    return view('thank-you');
});
Route::get('/unsubscribe', function () {
    if (!session()->has('message')) {
        return redirect('/');
    }
    return view('unsubscribe');
});

// Flutterwave webhook (topic payment)
Route::post('flutterwave/webhook', [SearchTopicController::class, 'webhook']);
Route::post('course/flutterwave/webhook', [CourseController::class, 'webhook']);

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', 
        [EmailVerificationController::class, 'notice']
    )->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', 
        [EmailVerificationController::class, 'verify']
    )->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', 
        [EmailVerificationController::class, 'resend']
    )->middleware('throttle:6,1')->name('verification.send');

});

Route::middleware('guest')->group(function () {

    Route::post('forgot-password', 
        [PasswordResetController::class, 'sendResetLinkEmail']
    )->middleware('throttle:3,1')->name('password.email');

    Route::get('reset-password/{token}', 
        [PasswordResetController::class, 'showResetForm']
    )->name('password.reset');

    Route::post('reset-password', 
        [PasswordResetController::class, 'reset']
    )->name('password.update');

});

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

// Signin with google
Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('google.login');
    Route::get('/auth/google/callback', 'callback')->name('google.callback');
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
            Route::patch('social-links', [SystemSettingController::class, 'updateSocialLinks'])->name('social.links');
        });

        // Suspensions
        Route::patch('admins/{admin}/suspend', [AdminController::class, 'suspend'])->name('admins.suspend');
        Route::patch('instructors/{instructor}/suspend', [AdminInstructorController::class, 'suspend'])->name('instructors.suspend');
        Route::patch('students/{student}/suspend', [AdminStudentController::class, 'suspend'])->name('student.suspend');

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

        Route::get('certificates/generate-code', [AdminCertificateController::class, 'generateCode'])
            ->name('certificates.generate_code');

        Route::patch('certificates/{certificate}/soft-delete', [AdminCertificateController::class, 'softDelete'])
            ->name('certificates.softDelete');

        Route::get('newsletter/{newsletter}/send', [NewslettersController::class, 'send'])
            ->name('newsletter.send');
        
        Route::patch('team-members/{teamMember}/toggle-status', [TeamController::class, 'toggleStatus'])
            ->name('team.toggle-status');

        Route::patch('testimonies/{testimony}/toggle-status', [TestimonyController::class, 'toggleStatus'])
            ->name('testimonies.toggle');

        Route::patch('product/{id}/toggle-status', [ProductController::class, 'toggleStatus'])
            ->name('product.toggle-status');

        Route::patch('gallery/{id}/toggle-status', [GalleryController::class, 'toggleStatus'])
            ->name('gallery.toggle-status');

        Route::prefix('siwes')->name('siwes.')->group(function () {
            Route::resource('tracks', SiwesTrackController::class)->except(['show']);
            
            Route::get('/', [AdminSiwesApplicationController::class, 'index'])->name('index');
            Route::get('/{application:reference}', [AdminSiwesApplicationController::class, 'show'])->name('show');
        });
        
        // Resources
        Route::resources([
            'admins' => AdminController::class,
            'courses' => AdminCoursesController::class,
            'certificates' => AdminCertificateController::class,
            'student' => AdminStudentController::class,
            'instructor' => AdminInstructorController::class,
            'transaction' => AdminTransactionController::class,
            'announcement' => AdminAnnouncementController::class,
            'topics' => TopicController::class,
            'news' => NewsController::class,
            'newsletter' => NewslettersController::class,
            'testimony' => TestimonyController::class,
            'team' => TeamController::class,
            'enrollments' => EnrollmentApplicationController::class,
            'product' => ProductController::class,
            'gallery' => GalleryController::class,
        ]);

        Route::get('enrollments-export', [EnrollmentApplicationController::class, 'exportAll'])
            ->name('enrollments.export');
        Route::get('enrollments-export-filtered', [EnrollmentApplicationController::class, 'exportFiltered'])
            ->name('enrollments.exportFiltered');
        Route::post('enrollments-bulk-action', [EnrollmentApplicationController::class, 'bulkAction'])
            ->name('enrollments.bulkAction');
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
            
        Route::get('activities', [StaffDashboardController::class, 'activities'])->name('activities');

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
Route::prefix('student')
    ->name('student.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
    
    Route::get('/', [StudentController::class, 'index'])->name('dashboard');
});