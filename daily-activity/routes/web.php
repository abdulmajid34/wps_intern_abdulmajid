<?php

use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\EmployeeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [EmployeeController::class, 'showLoginForm'])->name('login');
Route::post('/', [EmployeeController::class, 'postLogin']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [EmployeeController::class, 'logout']);

    Route::get('/dashboard', [DailyLogController::class, 'showDashboard'])->name('dashboard')->middleware(('auth'));
});
