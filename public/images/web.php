<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/', [ObatController::class, 'show'])->name('show');
Route::get('/register', [RegisterController::class , 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/home', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('admin');
//     Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
// });
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Route untuk Admin
Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
         ->name('admin.dashboard');
});

// Routes untuk User
Route::middleware(['auth', 'check.role:user'])->group(function () { Route::get('/user/dashboard', [User Controller::class, 'dashboard'])
         ->name('user.dashboard');
});

// Route untuk login dan logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route Untuk Obat
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('obat', ObatController::class);
});