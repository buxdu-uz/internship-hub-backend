<?php

use App\Http\Controllers\Applications\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Enterprises\EnterpriseController;
use App\Http\Controllers\Universities\UniversityController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//REGISTER
Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
Route::get('universities',[UniversityController::class, 'index']);

//GLOBAL ROUTE
Route::group(['middleware' => ['auth:sanctum','cors']], function(){
    Route::get('enterprise/all', [EnterpriseController::class,'getAll']);
    Route::get('roles', [UserController::class,'roles']);
    Route::get('user/all',[UserController::class,'getAll']);

    //ADMIN
    Route::group(['prefix' => 'admin','middleware' => ['role:admin']], function(){
        Route::get('users',[UserController::class,'getAllUsers']);
        Route::post('user_enterprises',[EnterpriseController::class,'userEnterprises']);
        Route::post('users',[UserController::class,'store']);
    });



//COMPANY-REPRESENTATIVE
    Route::group(['prefix' => 'company-representative','middleware' => ['role:company-representative']], function(){
        Route::post('application_check',[ApplicationController::class,'checkApplication']);
        Route::post('setBall',[ApplicationController::class,'setBall']);
    });



//TEACHER
    Route::group(['prefix' => 'teachers','middleware' => ['role:teacher']], function(){
        Route::post('applications',[ApplicationController::class,'store']);
            Route::post('upload/report',[ApplicationController::class,'uploadReportFile']);
    });



//    APPLICATIONS
    Route::get('applications',[ApplicationController::class,'index']);
});
