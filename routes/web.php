<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Donor\DonorList;
use App\Livewire\Donor\DonorForm;
use App\Livewire\DonationType\DonationTypeList;
use App\Livewire\DonationType\DonationTypeForm;
use App\Livewire\Donation\DonationList;
use App\Livewire\Donation\DonationForm;
use App\Livewire\Donation\DonationDetail;
use App\Livewire\Setting\OrganizationSettingForm;
use App\Livewire\User\UserList;
use App\Livewire\User\UserForm;
use App\Http\Controllers\ReportController;

// Redirect home to dashboard
Route::redirect('/', '/dashboard');

Route::view('dashboard', 'dashboard')
    ->name('dashboard');

// Publicly accessible report and breakdown pages
Route::get('/donation-types/{id}/details', \App\Livewire\DonationType\DonationTypeDetail::class)->name('donation-types.details');
Route::get('/donations/report-pdf', [ReportController::class, 'rekapPdf'])->name('donations.report-pdf');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    // Master Donatur
    Route::get('/donors', DonorList::class)->name('donors.index');
    Route::get('/donors/create', DonorForm::class)->name('donors.create');
    Route::get('/donors/{id}/edit', DonorForm::class)->name('donors.edit');

    // Master Jenis Donasi
    Route::get('/donation-types', DonationTypeList::class)->name('donation-types.index');
    Route::get('/donation-types/create', DonationTypeForm::class)->name('donation-types.create');
    Route::get('/donation-types/{id}/edit', DonationTypeForm::class)->name('donation-types.edit');

    // Transaksi Donasi
    Route::get('/donations', DonationList::class)->name('donations.index');
    Route::get('/donations/create', DonationForm::class)->name('donations.create');
    Route::get('/donations/{id}', DonationDetail::class)->name('donations.show');
    Route::get('/donations/{id}/edit', DonationForm::class)->name('donations.edit');
    Route::get('/donations/{id}/pdf', [ReportController::class, 'receiptPdf'])->name('donations.pdf');

    // Administrator Only Routes
    Route::middleware(['role:Administrator'])->group(function () {
        Route::get('/settings', OrganizationSettingForm::class)->name('settings');
        
        Route::get('/users', UserList::class)->name('users.index');
        Route::get('/users/create', UserForm::class)->name('users.create');
        Route::get('/users/{id}/edit', UserForm::class)->name('users.edit');
    });
});

require __DIR__.'/auth.php';
