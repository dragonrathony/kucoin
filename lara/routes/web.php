<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('home/auth', [HomeController::class, 'auth'])->name('home.auth');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/home/getCurrentPrice', [HomeController::class, 'getCurrentPrice'])->name('home.getCurrentPrice');
Route::post('/home/getAvailableTransferAmount', [HomeController::class, 'getAvailableTransferAmount'])->name('home.getAvailableTransferAmount');
Route::post('home/transfer', [HomeController::class, 'transfer'])->name('home.transfer');