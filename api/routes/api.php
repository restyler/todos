<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\TasksController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tasks', [TasksController::class, 'store']);
Route::get('/tasks', [TasksController::class, 'index']);
Route::delete('/tasks', [TasksController::class, 'delete']);
Route::patch('/task/done', [TasksController::class, 'done']);
Route::patch('/task/urgent', [TasksController::class, 'moveToUrgent']);
