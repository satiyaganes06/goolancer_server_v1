<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\User\UserDetailsController;

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

Route::group(['prefix' => 'user'], function(){
    Route::get('/settings', function(){ // result -> /admin/settings
        return "Settings";
    });
    
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/getUserProfileDetails', [UserDetailsController::class, 'getUserProfileDetail']);
    Route::post('/updateUserProfileInfo', [UserDetailsController::class, 'updateProfileInfo']);
    Route::post('/images',[CommonController::class, 'imageViewer']);
    
});

Route::group(['prefix' => 'client'], function(){
    
});

Route::group(['prefix' => 'expert'], function(){
    
});

Route::group(['prefix' => 'admin'], function(){
    
});


