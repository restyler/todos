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

use App\Http\Controllers\TaskController;
use App\Http\Controllers\BoardController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::delete('/tasks', [TaskController::class, 'delete']);
Route::patch('/task/done', [TaskController::class, 'done']);
Route::patch('/task/urgent', [TaskController::class, 'moveToUrgent']);

Route::get('/boards', [BoardController::class, 'index']);
