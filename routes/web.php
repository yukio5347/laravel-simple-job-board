<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostingController;
use Illuminate\Support\Facades\Route;

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

Route::get('jobs/{job}/amp', [JobPostingController::class, 'show'])->name('jobs.show.amp');
Route::get('jobs/{job}/delete', [JobPostingController::class, 'destroyConfirm'])->name('jobs.destroy.confirm');
Route::get('jobs/{job}/apply', [JobApplicationController::class, 'create'])->name('jobs.apply');
Route::post('jobs/{job}/apply', [JobApplicationController::class, 'store']);
Route::get('contact', [ContactController::class, 'create'])->name('contact');
Route::post('contact', [ContactController::class, 'store']);
Route::get('/', HomeController::class)->name('home');
Route::resource('jobs', JobPostingController::class);
