<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/user', [HomeController::class, 'all'])->name('user_list');
Route::post('/user', [HomeController::class, 'store'])->name('user_add');
Route::put('/user/{id}', [HomeController::class, 'update'])->name('user_update');
Route::delete('/user/{id}', [HomeController::class, 'delete'])->name('user_delete');

Route::get('/categories', [HomeController::class, 'listCategories'])->name('categories_list');

Route::get('/send-email', [EmailController::class, 'sendEmail']);
