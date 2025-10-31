<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OracleTestController;
use App\Http\Controllers\BaseAnvisaController;

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

// BASE_ANVISA Routes
Route::get('/base-anvisa', [BaseAnvisaController::class, 'index'])->name('base-anvisa.index');
Route::get('/base-anvisa/show', [BaseAnvisaController::class, 'show'])->name('base-anvisa.show');
Route::get('/base-anvisa/export', [BaseAnvisaController::class, 'export'])->name('base-anvisa.export');

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/oracle-test', [OracleTestController::class, 'apiTest'])->name('api.oracle.test');
    Route::get('/system-info', [OracleTestController::class, 'systemInfo'])->name('api.system.info');
    
    // BASE_ANVISA API Routes
    Route::get('/base-anvisa/search', [BaseAnvisaController::class, 'apiSearch'])->name('api.base-anvisa.search');
    Route::get('/base-anvisa/statistics', [BaseAnvisaController::class, 'apiStatistics'])->name('api.base-anvisa.statistics');
});