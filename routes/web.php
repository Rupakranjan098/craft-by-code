<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DigitalSolutionController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Admin\AboutContentController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SeoController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/services', [FrontendController::class, 'services'])->name('services.index');
Route::get('/services/{slug}', [FrontendController::class, 'serviceDetail'])->name('services.show');
Route::get('/digital-solutions', [FrontendController::class, 'digitalSolutions'])->name('solutions.index');
Route::get('/digital-solutions/{slug}', [FrontendController::class, 'solutionDetail'])->name('solutions.show');
Route::get('/portfolio', [FrontendController::class, 'portfolio'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [FrontendController::class, 'projectDetail'])->name('portfolio.show');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.show');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'submitInquiry'])->name('contact.submit');
Route::post('/newsletter', [FrontendController::class, 'newsletter'])->name('newsletter.subscribe');
Route::get('/hrms', function() {
    return redirect()->route('admin.hrms.dashboard');
})->name('hrms');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('password.email');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Back-Office Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modules CRUD
    Route::resource('services', ServiceController::class);
    Route::resource('solutions', DigitalSolutionController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('blog', BlogPostController::class);

    // Inquiries Management
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::put('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Website Content & Settings
    Route::get('/settings', [WebsiteSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [WebsiteSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset-logo', [WebsiteSettingController::class, 'resetLogo'])->name('settings.reset-logo');

    // About Us Content Management
    Route::get('/about-content', [AboutContentController::class, 'index'])->name('about.index');
    Route::get('/about-content/{about}/edit', [AboutContentController::class, 'edit'])->name('about.edit');
    Route::put('/about-content/{about}', [AboutContentController::class, 'update'])->name('about.update');

    // Profile & Password Change
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // SEO Settings
    Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
    Route::post('/seo', [SeoController::class, 'update'])->name('seo.update');

    // HRMS Suite (Admin-only Access)
    Route::prefix('hrms')->name('hrms.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\HrmsController::class, 'dashboard'])->name('dashboard');
        
        // Employees
        Route::get('/employees', [\App\Http\Controllers\Admin\HrmsController::class, 'employees'])->name('employees.index');
        Route::get('/employees/create', [\App\Http\Controllers\Admin\HrmsController::class, 'createEmployee'])->name('employees.create');
        Route::post('/employees', [\App\Http\Controllers\Admin\HrmsController::class, 'storeEmployee'])->name('employees.store');
        Route::get('/employees/{employee}/edit', [\App\Http\Controllers\Admin\HrmsController::class, 'editEmployee'])->name('employees.edit');
        Route::put('/employees/{employee}', [\App\Http\Controllers\Admin\HrmsController::class, 'updateEmployee'])->name('employees.update');
        Route::delete('/employees/{employee}', [\App\Http\Controllers\Admin\HrmsController::class, 'destroyEmployee'])->name('employees.destroy');

        // Departments
        Route::get('/departments', [\App\Http\Controllers\Admin\HrmsController::class, 'departments'])->name('departments.index');
        Route::post('/departments', [\App\Http\Controllers\Admin\HrmsController::class, 'storeDepartment'])->name('departments.store');
        Route::delete('/departments/{department}', [\App\Http\Controllers\Admin\HrmsController::class, 'destroyDepartment'])->name('departments.destroy');

        // Attendance
        Route::get('/attendance', [\App\Http\Controllers\Admin\HrmsController::class, 'attendance'])->name('attendance.index');
        Route::post('/attendance', [\App\Http\Controllers\Admin\HrmsController::class, 'markAttendance'])->name('attendance.mark');

        // Leave Requests
        Route::get('/leaves', [\App\Http\Controllers\Admin\HrmsController::class, 'leaves'])->name('leaves.index');
        Route::put('/leaves/{leave}/status', [\App\Http\Controllers\Admin\HrmsController::class, 'updateLeaveStatus'])->name('leaves.status');

        // Payroll
        Route::get('/payroll', [\App\Http\Controllers\Admin\HrmsController::class, 'payroll'])->name('payroll.index');
        Route::put('/payroll/{payroll}/status', [\App\Http\Controllers\Admin\HrmsController::class, 'updatePayrollStatus'])->name('payroll.status');
        Route::get('/payroll/{payroll}/payslip', [\App\Http\Controllers\Admin\HrmsController::class, 'payslip'])->name('payroll.payslip');
    });
});
