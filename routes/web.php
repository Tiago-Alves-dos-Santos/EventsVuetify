<?php

use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    Route::get('/', [EventoController::class, 'index'])->name('evento.index');
    Route::get('/eventos', [EventoController::class, 'eventos'])->name('evento.eventos');
});


