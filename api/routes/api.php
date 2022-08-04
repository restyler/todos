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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE, PATCH');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/task', [TaskController::class, 'store']);
Route::get('/tasks/all', [TaskController::class, 'all']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::delete('/task', [TaskController::class, 'delete']);
Route::patch('/task/done', [TaskController::class, 'done']);
Route::patch('/task/undone', [TaskController::class, 'undone']);
Route::patch('/task/urgent', [TaskController::class, 'moveToUrgent']);

Route::get('/boards', [BoardController::class, 'index']);
