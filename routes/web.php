<?php

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

Route::get('jobs/{job}/delete', [JobPostingController::class, 'destroyConfirm'])->name('jobs.destroy.confirm');
Route::resource('jobs', JobPostingController::class);
