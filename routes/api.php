<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TasksController;
use App\Http\Controllers\API\AdminController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/registeradmin', [App\Http\Controllers\API\AdminController::class, 'register']);
Route::post('/loginadmin', [App\Http\Controllers\API\AdminController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {


Route::get('/profileadmin',[App\Http\Controllers\API\AdminController::class,'profile']);


});


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class,'logout']);
    Route::post('/deletme',[App\Http\Controllers\API\AuthController::class,'deletme']);

    Route::resource('/tasks',App\Http\Controllers\API\TasksController::class);

});
