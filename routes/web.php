<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HistoricController;

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

Route::get('/', [EventController::class, 'index'])->name('index');
Route::group(['prefix' => '/events'], function () {
    Route::get('/', [EventController::class, 'viewEvents'])->name('event.viewEvents');
    Route::post('/events/create', [EventController::class, 'create'])->name('event.create');
    Route::put('/events/update', [EventController::class, 'update'])->name('event.update');
    Route::put('/events/cancel', [EventController::class, 'cancel'])->name('event.cancel');
    Route::delete('/events/delete/{id}', [EventController::class, 'delete'])->name('event.delete');
    Route::put('/events/restore', [EventController::class, 'restore'])->name('event.restore');
});
Route::group(['prefix' => '/historic'], function () {
    Route::get('/', [HistoricController::class, 'index'])->name('historic.index');
    Route::delete('/truncate', [HistoricController::class, 'truncate'])->name('historic.truncate');
});
