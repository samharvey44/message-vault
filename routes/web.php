<?php

use App\Livewire\About;
use App\Livewire\Home;
use App\Livewire\PreviewSecret;
use App\Livewire\ViewSecret;
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
Route::get('/about', About::class)->name('about');

Route::prefix('/secret')->name('secret.')->group(function () {
    Route::get('/preview', PreviewSecret::class)->name('preview');

    Route::get('/{token}', ViewSecret::class)
        ->name('view')
        ->middleware('signed');
});
