<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'App\Http\Controllers\PagesController@index');

Auth::routes();
// Route::get('/{any}', function(){
//     return view('welcome');
// });

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/{path}', [HomeController::class, 'index'])->where('path', '[-A-z0-9_\s]+');
Route::any('{all}', [HomeController::class, 'index'])
    ->where('all', '^(?!api).*$')
    ->where('all', '^(?!storage).*$');
