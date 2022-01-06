<?php

use App\Http\Controllers\Central\SiteController;
use App\Http\Controllers\Central\TenantController;
use App\Http\Controllers\GoogleController;
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
Route::get('/', function(){
    return abort(503);
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function(){
    Route::get('/', [TenantController::class, 'dashboard'])->name('dashboard');
    Route::resource('/tenants', TenantController::class);
});

Route::get('/criar-conta', [SiteController::class, 'create'])->name('website.create');
Route::post('/criar-conta', [TenantController::class, 'store'])->name('website.store');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

