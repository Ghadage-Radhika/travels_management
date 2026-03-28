<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\PageController;

// ─── Public Pages ───────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about',   [PageController::class, 'about'])->name('about');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// ─── Auth ────────────────────────────────────────────────────────────────────
Route::get('/register',  [AuthController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::get('/login',     [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login',    [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout',   [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ─── Protected ───────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // User
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/enquiry',  [DashboardController::class, 'storeEnquiry'])->name('enquiry.store');

    // Manager + Admin
    Route::middleware('role:admin,manager')->group(function () {

        Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
        Route::patch('/manager/enquiry/{id}/resolve', [ManagerController::class, 'resolveEnquiry'])->name('manager.enquiry.resolve');
        Route::delete('/manager/enquiry/{id}',        [ManagerController::class, 'destroyEnquiry'])->name('manager.enquiry.destroy');

        // ── Bus Booking Module ──────────────────────────────────────────────
        // NOTE: static routes MUST come before {id} wildcard routes
        Route::get('/manager/booking/export-pdf', [ManagerController::class, 'exportBookingsPdf'])->name('manager.booking.export.pdf');
        Route::get('/manager/booking/print',      [ManagerController::class, 'printBookings'])->name('manager.booking.print');
        Route::post('/manager/booking',           [ManagerController::class, 'storeBooking'])->name('manager.booking.store');
        Route::put('/manager/booking/{id}',       [ManagerController::class, 'updateBooking'])->name('manager.booking.update');
        Route::delete('/manager/booking/{id}',    [ManagerController::class, 'destroyBooking'])->name('manager.booking.destroy');

        // ── Billing Module ──────────────────────────────────────────────────
        // NOTE: static routes (pdf, print) MUST come before {id} routes
        Route::get('/manager/billing/{id}/pdf',   [ManagerController::class, 'exportBillingPdf'])->name('manager.billing.pdf');
        Route::get('/manager/billing/{id}/print', [ManagerController::class, 'printBilling'])->name('manager.billing.print');
        Route::post('/manager/billing',           [ManagerController::class, 'storeBilling'])->name('manager.billing.store');
        Route::put('/manager/billing/{id}',       [ManagerController::class, 'updateBilling'])->name('manager.billing.update');
        Route::delete('/manager/billing/{id}',    [ManagerController::class, 'destroyBilling'])->name('manager.billing.destroy');

        // ── Maintenance Module ──────────────────────────────────────────────
        // IMPORTANT: static routes (export-pdf, image-delete) MUST come before {id} wildcard routes

        Route::get('/manager/maintenance/export-pdf',           [ManagerController::class, 'exportMaintenancePdf'])->name('manager.maintenance.export.pdf');

        // NEW ── Delete a single image field from a record (AJAX)
        Route::delete('/manager/maintenance/{id}/image/{field}', [ManagerController::class, 'deleteMaintenanceImage'])->name('manager.maintenance.image.delete');

        Route::post('/manager/maintenance',           [ManagerController::class, 'storeMaintenance'])->name('manager.maintenance.store');
        Route::put('/manager/maintenance/{id}',       [ManagerController::class, 'updateMaintenance'])->name('manager.maintenance.update');
        Route::delete('/manager/maintenance/{id}',    [ManagerController::class, 'destroyMaintenance'])->name('manager.maintenance.destroy');

        Route::resource('travels', TravelController::class);
        Route::get('/travels-export', [TravelController::class, 'export'])->name('travels.export');

        // ── Tax Module ──────────────────────────────────────────────────────
        // NOTE: static routes (export-pdf, print) MUST come before {tax} wildcard routes
        Route::get   ('/manager/tax/export-pdf',         [ManagerController::class, 'exportTaxPdf'])          ->name('manager.tax.export.pdf');
        Route::get   ('/manager/tax/print',              [ManagerController::class, 'printTaxAll'])           ->name('manager.tax.print.all');
        Route::get   ('/manager/tax/{tax}/pdf',          [ManagerController::class, 'exportTaxRecordPdf'])    ->name('manager.tax.pdf');
        Route::get   ('/manager/tax/{tax}/print',        [ManagerController::class, 'printTaxRecord'])        ->name('manager.tax.print');
        Route::post  ('/manager/tax',                    [ManagerController::class, 'storeTax'])               ->name('manager.tax.store');
        Route::put   ('/manager/tax/{tax}',              [ManagerController::class, 'updateTax'])              ->name('manager.tax.update');
        Route::delete('/manager/tax/{tax}',              [ManagerController::class, 'destroyTax'])             ->name('manager.tax.destroy');

        // ── Insurance Module ────────────────────────────────────────────────
        // NOTE: static routes MUST come before {insurance} wildcard routes
        Route::get   ('/manager/insurance/export-pdf',              [ManagerController::class, 'exportInsurancePdf'])          ->name('manager.insurance.export.pdf');
        Route::get   ('/manager/insurance/print',                   [ManagerController::class, 'printInsuranceAll'])           ->name('manager.insurance.print.all');
        Route::get   ('/manager/insurance/{insurance}/pdf',         [ManagerController::class, 'exportInsuranceRecordPdf'])    ->name('manager.insurance.pdf');
        Route::get   ('/manager/insurance/{insurance}/print',       [ManagerController::class, 'printInsuranceRecord'])        ->name('manager.insurance.print');
        Route::post  ('/manager/insurance',                         [ManagerController::class, 'storeInsurance'])               ->name('manager.insurance.store');
        Route::put   ('/manager/insurance/{insurance}',             [ManagerController::class, 'updateInsurance'])              ->name('manager.insurance.update');
        Route::delete('/manager/insurance/{insurance}',             [ManagerController::class, 'destroyInsurance'])             ->name('manager.insurance.destroy');
    });
});