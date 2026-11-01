<?php

use App\Http\Controllers\CycleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\SymptomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Dashboard Utama (shadcn dashboard-01 pink)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Resource Route Master Data Periode (Modul SIMTIKUM Pertemuan 5)
Route::resource('periode', PeriodeController::class)->except('show');

// 3. Resource Route Fitur Aplikasi Red Menstruasi
Route::resource('cycles', CycleController::class)->except('show');
Route::resource('symptoms', SymptomController::class)->except('show');
Route::resource('medications', MedicationController::class)->except('show');
Route::resource('reminders', ReminderController::class)->except('show');
