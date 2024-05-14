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
use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\Revenue\ExpertRevenueController;
use App\Http\Controllers\Base\BaseController;

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
    
    //Base
    Route::post('/uploadImage', [BaseController::class, 'uploadImage']);

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
    Route::post('/getBookingRequestNegotiation', [BookingRequestController::class, 'getBookingRequestNegotiationByID']);
    Route::post('/updateBookingRequestNegotiationStatus', [BookingRequestController::class, 'updateBookingRequestNegotiationStatus']);
    Route::post('/updateBookingRequestAcceptReq', [BookingRequestController::class, 'updateBookingRequestAcceptReq']);
    Route::post('/addNegotiation', [BookingRequestController::class, 'addNegotiation']);

    //Job
    Route::post('/getJobMainList', [JobController::class, 'viewJobMainList']);
    Route::post('/getJobPaymentByID', [JobController::class, 'getJobPaymentByJobMainID']);
    Route::post('/getJobMainByID', [JobController::class, 'getJobMainByID']);
    Route::post('/getJobResultByJobMainID', [JobController::class, 'getJobResultByJobMainID']);
    Route::post('/addJobComment', [JobController::class, 'addJobComment']);
    Route::post('/getJobCommentByJobResultID', [JobController::class, 'getJobCommentByJobResultID']);
    Route::post('/getJobResultDeliveryByJobMainID', [JobController::class, 'getJobResultDeliveryByJobMainID']);
    Route::post('/getRatingByJobMainID', [JobController::class, 'getJobUserRating']);

    //Rating
    Route::post('/getUserRatingListByServiceID', [JobController::class, 'getUserRatingListByServiceID']);
    
    //Revenue
    Route::post('/getRefundDetailsByJobMainID', [ExpertRevenueController::class, 'getRefundDetailsByJobMainID']);
    Route::post('/getTransactionHistoryByUserID', [ExpertRevenueController::class, 'getTransactionHistoryByUserID']);

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
    Route::post('/getServiceRequestByID', [BookingRequestController::class, 'getBookingRequestByID']);

    //Job
    Route::post('/addJobPayment', [JobController::class, 'addJobPayment']);
    Route::post('/updateJobResultStatus', [JobController::class, 'updateJobResultStatus']);
    Route::post('/updateJobResultComplete', [JobController::class, 'updateJobResultComplete']);
    Route::post('/getJobResultComments', [JobController::class, 'getJobResultComments']);
    Route::post('/getJobResultByID', [JobController::class, 'getJobResultByID']);
    Route::post('/addJobUserRating', [JobController::class, 'addJobUserRating']);
    
    //Revenue
    Route::post('/refundRequest', [ExpertRevenueController::class, 'refundRequest']);
    Route::post('/penaltyPayment', [ExpertRevenueController::class, 'penaltyPayment']);
    Route::post('/checkTransactionType', [ExpertRevenueController::class, 'checkTransactionType']);
});

Route::group(['prefix' => 'expert'], function(){

    //Service
    Route::post('/getAllServiceByExpertID', [ExpertServiceController::class, 'getAllServiceByExpertID']);
    Route::post('/addService', [ExpertServiceController::class, 'addService']);

    //Post
    Route::post('/addPost', [ExpertPostController::class, 'addPost']);
    Route::post('/getAllExpertPost', [ExpertPostController::class, 'getAllExpertPosts']);
    Route::post('/deletePost', [ExpertPostController::class, 'deletePost']);

    //Certificate
    Route::post('/getAllExpertCertificateListByExpertID', [ExpertCertificateController::class, 'getAllExpertCertificateListByExpertID']);
    Route::post('/addCertificate', [ExpertCertificateController::class, 'addCertificate']);
    Route::post('/updateCertificateDetails', [ExpertCertificateController::class, 'updateCertificateDetails']);
    Route::post('/deleteCertificate', [ExpertCertificateController::class, 'deleteCertificate']);

    //Booking
    Route::post('/getExpertBookingRequestList', [BookingRequestController::class, 'getExpertBookingRequest']);

    //Job
    Route::post('/getJobPaymentByExpertID', [JobController::class, 'getJobPaymentByExpertID']);
    Route::post('/getJobMainNBookingReqByJobMainID', [JobController::class, 'getJobMainNBookingReqByJobMainID']);
    Route::post('/getJobMainList', [JobController::class, 'viewJobMainListForExpert']);
    Route::post('/uploadJobResultProgress', [JobController::class, 'uploadJobResultProgress']);

    //Revenue
    Route::post('/addExpertRevenue', [ExpertRevenueController::class, 'addExpertRevenue']);
    Route::post('/getExpertRevenue', [ExpertRevenueController::class, 'getExpertRevenue']);
    Route::post('/getTransactionHistory', [ExpertRevenueController::class, 'getTransactionHistory']);
    Route::post('/requestWithdrawal', [ExpertRevenueController::class, 'requestWithdrawal']);
    Route::post('/completeDelivery', [ExpertRevenueController::class, 'completeDelivery']);

});

Route::group(['prefix' => 'admin'], function(){

});


