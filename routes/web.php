<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\NotificationTargetController;
use App\Models\Guest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('guests', GuestController::class);
Route::get('logs', [GuestController::class, 'index'])->name('logs');
Route::resource('vehicles', VehicleController::class);
Route::resource('settings', SettingController::class);
Route::get('guests/print/{guest}', [GuestController::class, 'print'])->name('guests.print');
Route::resource('notification-targets', NotificationTargetController::class);
Route::get('/guest/scan', [GuestController::class, 'showScanPage'])->name('guest.scan');
Route::post('/guest/scan', [GuestController::class, 'scan'])->name('guest.scan.post');





