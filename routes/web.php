<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RentCarController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Admin\FinanceReportController; // ✅ TAMBAHAN
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirect default '/login' ke '/admin/login'
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Language Switcher
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('language');

// Route untuk switch bahasa
Route::get('language/{lang}', [LanguageController::class, 'switch'])->name('language');


// =======================
// PUBLIC ROUTES
// =======================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Packages
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');

// Rent Cars
Route::get('/rent-car', [RentCarController::class, 'index'])->name('rentcar.index');
Route::get('/rent-car/{id}', [RentCarController::class, 'show'])->name('rentcar.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Booking Submission (Public)
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');


// =======================
// ADMIN ROUTES
// =======================

Route::prefix('admin')->name('admin.')->group(function () {

    // -----------------------
    // ADMIN AUTH (PUBLIC)
    // -----------------------
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');


    // -----------------------
    // PROTECTED ADMIN ROUTES
    // -----------------------
    Route::middleware(['auth', 'admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        // =======================
        // PACKAGES CRUD
        // =======================
        Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);

        // Rent Cars CRUD
        Route::resource('rent-cars', \App\Http\Controllers\Admin\RentCarController::class);

        // Blog CRUD
        Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);


        // =======================
        // PENGAJUAN CRUD
        // =======================
        Route::resource('pengajuans', PengajuanController::class);
        Route::get('/pengajuans/{pengajuan}/pdf', [PengajuanController::class, 'pdf'])->name('pengajuans.pdf');


        // ==========================================
        // BOOKINGS MANAGEMENT
        // ==========================================
        Route::get('/bookings/create', [DashboardController::class, 'createBooking'])->name('bookings.create');
        Route::get('/bookings/get-pricing/{id}', [DashboardController::class, 'getPackagePricing'])->name('bookings.get-pricing');
        Route::post('/bookings/store-manual', [DashboardController::class, 'storeManualBooking'])->name('bookings.store-manual');
        Route::get('/bookings', [DashboardController::class, 'bookings'])->name('bookings.index');
        Route::get('/bookings/{id}', [DashboardController::class, 'bookingDetail'])->name('bookings.show');
        Route::put('/bookings/{id}/status', [DashboardController::class, 'updateBookingStatus'])->name('bookings.update-status');
        Route::delete('/bookings/{id}', [DashboardController::class, 'destroyBooking'])->name('bookings.destroy');
        Route::get('/bookings/{id}/invoice', [DashboardController::class, 'generateInvoice'])->name('bookings.invoice');


        // =======================
        // CONTACTS MANAGEMENT
        // =======================
        Route::get('/contacts', [DashboardController::class, 'contacts'])->name('contacts.index');
        Route::post('/contacts/{id}/reply', [DashboardController::class, 'replyContact'])->name('contacts.reply');


        // =======================
        // REPORTS
        // =======================
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
        Route::get('/reports/export', [DashboardController::class, 'exportReport'])->name('reports.export');


        // =======================
        // FINANCE REPORTS CRUD  ✅ TAMBAHAN BARU
        // =======================
        Route::resource('finance-reports', FinanceReportController::class);
        Route::get('/finance-reports/export/csv', [FinanceReportController::class, 'export'])->name('finance-reports.export');
        Route::get('/finance-reports/print/pdf', [FinanceReportController::class, 'pdf'])->name('finance-reports.pdf');
    });
});
