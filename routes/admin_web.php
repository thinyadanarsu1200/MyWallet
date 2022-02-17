<?php

use App\Http\Controllers\Auth\AdminSessionController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->group(function () {
  Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AdminSessionController::class, 'create'])->name('login');
    Route::post('login', [AdminSessionController::class, 'store'])->name('login.store');
    Route::post('logout', [AdminSessionController::class, 'destroy'])->withoutMiddleware('guest:admin');
  });
  Route::middleware('auth:admin')->group(function () {
    Route::resource('admin-user', AdminUserController::class);
    Route::delete('/delete-selected-admin-user/{admins_id}', [AdminUserController::class, 'destroySelected']);
    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::get('show-admin-list', [AdminUserController::class, 'showAdminList']);
    Route::get('show-user-list', [UserController::class, 'showUserList']);

    Route::get('wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('show-wallet-list', [WalletController::class, 'showWalletList']);
  });

});
