<?php

use App\Http\Resources\UserResource;
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
Route::namespace('Api')->group(function() {
    Route::post('/login','AuthController@login');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user',function(Request $request)
        {
            return new UserResource($request->user()); 
        });
        Route::apiResource('question', 'QuestionController');
        Route::apiResource('/class','ClassController');
        Route::apiResource('/course','CourseController');
        Route::apiResource('/users','UserController');
        Route::put('update-password', 'UserController@updateNewPassword');
        Route::post('/logout','AuthController@logout');
    });
});
