<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

// Route::get('/', function() {
//     return view('index');
// });

// トップページ表示
Route::get('/', [TodoController::class, 'index']);

// todo作成時
Route::post('/todos', [TodoController::class, 'store']);

// todo更新時
Route::patch('/todos/update', [TodoController::class, 'update']);