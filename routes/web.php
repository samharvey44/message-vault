<?php

use App\Livewire\Home;
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

Route::get('/', Home::class)->name('home');

Route::get('/about', fn () => 'about')->name('about');

Route::prefix('/secret')->name('secret')->group(function () {
    Route::get('/preview', fn () => 'preview')->name('.preview');
    Route::get('/{token}', fn () => 'view');
});
