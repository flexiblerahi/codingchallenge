<?php

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/sendrequest', [App\Http\Controllers\NetworkController::class, 'sendrequest']);
Route::post('/withdrawrequest', [App\Http\Controllers\NetworkController::class, 'withdrawrequest']);
Route::post('/acceptrequest', [App\Http\Controllers\NetworkController::class, 'acceptrequest']);
Route::post('/removeconnection', [App\Http\Controllers\NetworkController::class, 'removeconnection']);
Route::get('/getsuggestion', [App\Http\Controllers\NetworkController::class, 'getsuggestion']);