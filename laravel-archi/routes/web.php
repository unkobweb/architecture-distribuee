<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;
use Whoops\Run;

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
Route::get('/', [BusinessController::class, 'index']);
Route::get('/search', [BusinessController::class, 'search'])->name('search');
Route::get('/show/{id}', [BusinessController::class, 'show'])->name('show');