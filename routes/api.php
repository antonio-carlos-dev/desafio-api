<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\MoveController;
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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');

Route::apiResource('teams', TeamController::class)->middleware('auth:sanctum');
Route::get('teams/{id}/projects', [TeamController::class, 'showProjects' ])->middleware('auth:sanctum');
Route::post('teams/{id}/associate', [TeamController::class, 'associate' ])->middleware('auth:sanctum');
Route::post('teams/{id}/disassociate', [TeamController::class, 'disassociate' ])->middleware('auth:sanctum');

Route::apiResource('projects', ProjectController::class)->middleware('auth:sanctum');
Route::get('projects/{id}/columns', [ProjectController::class, 'showColumns'])->middleware('auth:sanctum');

Route::apiResource('columns', ColumnController::class)->middleware('auth:sanctum');
Route::get('columns/{id}/cards', [ColumnController::class, 'showCards'])->middleware('auth:sanctum');

Route::apiResource('cards', CardController::class)->middleware('auth:sanctum');
Route::put('move/cards/{id}', [MoveController::class, 'move'])->middleware('auth:sanctum');
