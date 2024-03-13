<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ErrorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/user', [UserController::class, 'index']);
    Route::put('/user/access', [UserController::class, 'access']);


    Route::get('/task', [TaskController::class, 'index']);
    Route::post('/task/create', [TaskController::class, 'store']);
    Route::post('/task/{id}', [TaskController::class, 'update']);
    Route::delete('/task/{id}', [TaskController::class, 'delete']);
    Route::delete('/task/image/{id}', [TaskController::class, 'deleteImage']);
    Route::get('/task/{id}', [TaskController::class, 'show']);
});

// public access
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::get('/auth', [AuthController::class, 'auth']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/create', [AuthController::class, 'register']);
Route::get('/page-not-found', [ErrorController::class, 'index'] )->name('page_not_found');
