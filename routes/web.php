<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\ServicePageController;
use App\Http\Controllers\Public\ProductPageController;
use App\Http\Controllers\Public\GalleryPageController;
use App\Http\Controllers\Public\ContactPageController;
use App\Http\Controllers\Public\BookingController;
use App\Http\Controllers\Public\BookingSlotsController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BookingCalendarController;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/services', [ServicePageController::class, 'index'])->name('services');
Route::get('/products', [ProductPageController::class, 'index'])->name('products');
Route::get('/gallery', [GalleryPageController::class, 'index'])->name('gallery');
Route::get('/contact', [ContactPageController::class, 'index'])->name('contact');

/** Booking (public) */
Route::get('/book', [BookingController::class, 'create'])->name('book');
Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::get('/book/success/{booking}', [BookingController::class, 'success'])->name('book.success');

/** Booking slots API */
Route::get('/book/slots', [BookingSlotsController::class, 'index'])->name('book.slots');


/*
|--------------------------------------------------------------------------
| Auth redirect target (needed when middleware uses "auth")
|--------------------------------------------------------------------------
| Your custom admin login lives at /admin/login, but some middleware tries /login.
*/
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| Admin Auth (NOT protected)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| Admin Area (Protected)
|--------------------------------------------------------------------------
| admin.auth = your custom admin session login middleware
| superadmin = role_id = 1 only
|--------------------------------------------------------------------------
*/
Route::middleware(['admin.auth'])->prefix('admin')->group(function () {

    /**
     * Dashboard
     * - Admin (role_id=2) should basically go to bookings page
     * - SuperAdmin can still use dashboard page
     */
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    /**
     * ✅ BOTH roles: Bookings
     */
    Route::get('/bookings', [AdminBookingController::class, 'index'])
        ->name('admin.bookings.index');

    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])
        ->name('admin.bookings.show');

    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])
        ->name('admin.bookings.status');

    Route::get('/bookings/calendar/events', [BookingCalendarController::class, 'events'])
        ->name('admin.bookings.calendar.events');

    /**
     * ✅ BOTH roles: Barbers  (ONLY HERE)
     */
    Route::resource('barbers', \App\Http\Controllers\Admin\BarberController::class)
        ->names('admin.barbers');

    /**
     * ✅ SUPER ADMIN ONLY: Services, Products, Gallery, Settings
     */
    Route::middleware(['superadmin'])->group(function () {

        Route::resource('services', ServiceController::class)
            ->names('admin.services');

        Route::resource('products', ProductController::class)
            ->names('admin.products');

        Route::resource('gallery', GalleryController::class)
            ->names('admin.gallery');

        Route::get('/settings', [SettingController::class, 'edit'])
            ->name('admin.settings.edit');

        Route::post('/settings', [SettingController::class, 'update'])
            ->name('admin.settings.update');

        
    });
});
