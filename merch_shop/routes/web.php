<?php

use App\Http\Controllers\PageWebController;
use App\Http\Controllers\NewsWebController;
use App\Http\Controllers\AppealWebController;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\CatalogWebController;
use App\Http\Controllers\ProductWebController;
use App\Http\Controllers\CartWebController;
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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/pages', [PageWebController::class, 'index']);
Route::get('/pages/{slug}', [PageWebController::class, 'show']);
Route::get('/news', [NewsWebController::class, 'index']);
Route::get('/news/{slug}', [NewsWebController::class, 'show']);

Route::get('/appeal', [AppealWebController::class, 'form'])->name('appeal.form');
Route::post('/appeal', [AppealWebController::class, 'send'])->name('appeal.send');

Route::get('/login', [AuthWebController::class, 'loginForm'])->name('login');
Route::get('/register', [AuthWebController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthWebController::class, 'register'])->name('register.post');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthWebController::class, 'logout'])->name('logout');
Route::get('/profile',[ProfileController::class,'show'])->name('profile')->middleware('auth');

Route::prefix('/oauth')->group(function () {
    Route::get('/{provider}/redirect', [OAuthController::class, 'redirectToService'])->name('oauth.redirect');
    Route::get('/{provider}/login', [OAuthController::class, 'login'])->name('oauth.login');
});

Route::get('/catalog/{slug?}', [CatalogWebController::class, 'index'])->name('catalog');
Route::get('/catalog/product/{slug}', [ProductWebController::class, 'index'])->name('product');

Route::get('/cart', CartWebController::class)->middleware('auth.optional');
