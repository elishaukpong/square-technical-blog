<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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


Route::get('/', [HomeController::class, 'index']);
Route::get('/blog', [HomeController::class,'posts'])->name('show.post.all');
Route::get('/blog/{slug}', [HomeController::class,'show'])->name('show.post');
Route::get('/suggest', [HomeController::class,'suggest'])->name('suggest');


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::resource('posts',PostController::class)->except(['show']);
});


require __DIR__.'/auth.php';
