<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\VehicleController;
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
Route::resource('vehicles', VehicleController::class);
Route::get('/guest/log', function () {
    $guests = Guest::all();
    return view('guest.log', compact('guests'));
})->name('guest.log');
