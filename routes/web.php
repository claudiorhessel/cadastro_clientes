<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('customerEdit');
Route::post('/insert', [App\Http\Controllers\HomeController::class, 'insert'])->name('customerInsert');
Route::get('/remove', [App\Http\Controllers\HomeController::class, 'remove'])->name('customerRemove');
