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

use App\Http\Controllers\TasksController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/tasks', [TasksController::class, 'store']);
Route::get('/tasks', [TasksController::class, 'index']);
Route::delete('/tasks', [TasksController::class, 'delete']);
Route::patch('/task/done', [TasksController::class, 'done']);
Route::patch('/task/urgent', [TasksController::class, 'moveToUrgent']);
