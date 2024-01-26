<?php

use App\Http\Controllers\GuestController;
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

Route::get('guest', [GuestController::class, 'index'])->name('guest.index');
Route::get('guests/create', [GuestController::class, 'create'])->name('guest.create');
Route::post('guests', [GuestController::class, 'store'])->name('guest.store');
Route::get('guests/{guest}', [GuestController::class, 'edit'])->name('guest.edit');
Route::put('guests/{guest}', [GuestController::class, 'update'])->name('guest.update');
Route::delete('guests/{guest}', [GuestController::class, 'destroy'])->name('guest.destroy');
