<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TodoController;
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

Route::get('/', [TodoController::class, 'index'])->name('index');
Route::post('store', [TodoController::class, 'store'])->name('store-todo');
Route::post('delete', [TodoController::class, 'delete'])->name('task-delete');
Route::post('update', [TodoController::class, 'update'])->name('task-complete');
Route::get('show-all', [TodoController::class, 'show_all'])->name('show-all');
