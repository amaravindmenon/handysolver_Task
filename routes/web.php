<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\nameController;

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

Route::get('/',[categoryController::class,'index'] );

Route::post('/addTodo',[nameController::class,'store']);
Route::get('/getTodo',[nameController::class,'index']);
//Route::post('/editTodo',[nameController::class,'edit']);
Route::post('/deleteTodo',[nameController::class,'destroy']);
