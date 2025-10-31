<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OracleTestController;

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

// Oracle Test Routes
Route::get('/oracle-test', [OracleTestController::class, 'index'])->name('oracle.test');
Route::get('/system-info', [OracleTestController::class, 'systemInfo'])->name('system.info');

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/oracle-test', [OracleTestController::class, 'apiTest'])->name('api.oracle.test');
    Route::get('/system-info', [OracleTestController::class, 'systemInfo'])->name('api.system.info');
});