<?php

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json([
        'status' => false,
        'message' => 'Token tidak valid'
    ], 401);
})->name('login');

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('current-user',[UserController::class,'currentUser']);
    Route::patch('update-user',[UserController::class,'updateUser']);
    Route::delete('logout',[UserController::class,'logout']);
});

Route::get('properties',[PropertyController::class,'index']);
Route::get('properties/{id}',[PropertyController::class,'show']);
