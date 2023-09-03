<?php declare(strict_types=1);

namespace Aplag;

use Aplag\App\Http\Controllers\AplagController;
use Aplag\App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AplagController::class, 'index'])->name('start');
Route::post('/', [AplagController::class, 'compared'])->name('compared');
Route::post('/excel', [ExcelController::class, 'export'])->name('excel');

