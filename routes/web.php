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

  Route::get('/home/transfer', [PageController::class, 'transfer'])->name('transfer');

  Route::get('/profile', [PageController::class, 'profile'])->name('profile');
  Route::get('/profile/edit', [PageController::class, 'edit'])->name('edit-profile');
  Route::post('/profile/update', [PageController::class, 'update'])->name('update-profile');
  Route::get('/profile/change_password', [PageController::class, 'changePassword'])->name('change-password');
  Route::post('/profile/change_password_action/{$id}', [PageController::class, 'changePasswordAction'])->name('change-password-action');
});
