<?php

use App\Http\Controllers\Frontend\PageController;
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

Route::middleware('auth')->group(function () {
  Route::get('/', [PageController::class, 'home']);
  Route::post('logout', [PageController::class, 'destroy'])->withoutMiddleware('guest:auth');

  Route::get('/home/transfer', [PageController::class, 'transfer'])->name('transfer')->middleware('prevent-back-history');
  Route::get('/home/transfer/search-transfer-phone', [PageController::class, 'searchTransferPhone'])->middleware('prevent-back-history');
  Route::post('/home/transfer', [PageController::class, 'transferAction'])->name('transfer-action')->middleware('prevent-back-history');
  Route::post('/home/transfer/checkPassword', [PageController::class, 'checkPassword'])->name('check-password')->middleware('prevent-back-history');
  Route::post('home/transfer/sendTransfer', [PageController::class, 'sendTransfer'])->name('transfer.send')->middleware('prevent-back-history');
  Route::get('/home/transfer/success-transfer', [PageController::class, 'successTransfer'])->name('success-transfer')->middleware('prevent-back-history');

  // Transaction
  Route::get('home/transaction', [PageController::class, 'transaction'])->name('transaction');
  Route::get('home/transaction/{trx_id}', [PageController::class, 'transactionDetail'])->name('transaction.detail');

  Route::get('/profile', [PageController::class, 'profile'])->name('profile');
  Route::get('/profile/edit', [PageController::class, 'edit'])->name('edit-profile');
  Route::post('/profile/update', [PageController::class, 'update'])->name('update-profile');
  Route::get('/profile/change_password', [PageController::class, 'changePassword'])->name('change-password');
  Route::post('/profile/change_password_action/{$id}', [PageController::class, 'changePasswordAction'])->name('change-password-action');
});
