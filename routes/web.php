<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

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
Route::group( [ 'prefix' => '/' ], function()
{
    Route::get('/', [EventController::class, 'index'])->name('event.index');
    Route::get('/events', [EventController::class, 'eventos'])->name('event.events');
    Route::post('/events/create', [EventController::class, 'create'])->name('event.create');
});


