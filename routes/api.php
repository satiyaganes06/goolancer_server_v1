<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Service\ExpertServiceController;
use App\Http\Controllers\Certificate\ExpertCertificateController;
use App\Http\Controllers\User\UserDetailsController;
use App\Http\Controllers\Post\ExpertPostController;
use App\Http\Controllers\Booking\BookingRequestController;

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

    //Auth
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/getUserProfileDetails', [UserDetailsController::class, 'getUserProfileDetail']);
    Route::post('/updateUserProfileInfo', [UserDetailsController::class, 'updateProfileInfo']);

    //Image Viewer
    Route::post('/images',[CommonController::class, 'imageViewer']);

    //Service
    Route::post('/getAllServiceByID', [ExpertServiceController::class, 'getAllServiceByID']);

    //Post
    Route::post('/getAllExpertPost', [ExpertPostController::class, 'getAllExpertPost']);
    Route::post('/getAllExpertPostByServiceCategory', [ExpertPostController::class, 'getAllExpertPostByServiceCategory']);

    //Negotiation
    Route::post('/getBookingRequestNegotiation', [BookingRequestController::class, 'getBookingRequestNegotiation']);
});

Route::group(['prefix' => 'client'], function(){

    //Service
    Route::get('/getAllService', [ExpertServiceController::class, 'getAllServiceList']);

    //Certificate
    Route::post('/getExpertCertificateByService', [ExpertCertificateController::class, 'getExpertCertificateByService']);

    //Post
    Route::post('/getExpertPostByService', [ExpertPostController::class, 'getExpertPostByService']);

    //Service request
    Route::post('/addServiceRequest', [BookingRequestController::class, 'addBookingRequest']);
    Route::post('/getServiceRequest', [BookingRequestController::class, 'viewBookingRequest']);


});

Route::group(['prefix' => 'expert'], function(){

});

Route::group(['prefix' => 'admin'], function(){

});


