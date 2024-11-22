<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\Users\BeliController;
use App\Http\Controllers\Users\CheckOutController;

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

Route::get('/', [SearchController::class, 'usersSearch_notLogin'])->name('welcome');

// INFO: Login dan register route
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// INFO: admin route
Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [UsersController::class, 'show'])->name('admin.users');
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::resource('obat', ObatController::class);
    });
});

// INFO: user route
Route::middleware(['auth', 'check.role:user'])->group(function () {
    Route::get('/users/dashboard', [UsersController::class, 'index'])->name('users.dashboard');
    Route::get('/users/profile', [UsersController::class, 'profile'])->name('users.profile');
    Route::get('/users/riwayatPembelian', [UsersController::class, 'riwayatPembelian'])->name('users.riwayatPembelian');
    Route::post('/users/keranjang', [CheckOutController::class, 'checkout'])->name('users.keranjang.checkout');
    Route::post('/users/dashboard', [BeliController::class, 'index'])->name('users.beli');
    Route::prefix('user')->name('user.keranjang.')->middleware(['auth'])->group(function () {
        // Route::get('/', [KeranjangController::class, 'index'])->name('index');
        Route::post('/keranjang', [KeranjangController::class, 'store'])->name('store');
        Route::get('/keranjang', [KeranjangController::class, 'show'])->name('show');
        Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('destroy');
        Route::get('/report-detail-pembelian', [KeranjangController::class, 'reportDetailPembelian'])->name('report');
    });
});
