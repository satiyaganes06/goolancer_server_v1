<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserAccountController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\CommonController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Route::group(['prefix' => 'user'], function(){

    Route::get('/imageViewer/{filepath}',[CommonController::class, 'imageViewer'])->name('image.show');
    Route::get('/displayImage/{app}/{uploads}/{folder}/{category}/{filename}',[CommonController::class, 'displayImage']);

});

Route::get('/login',[AdminController::class, 'AdminLogin'])->name('login');
Route::post('/loginSubmit',[AuthController::class, 'adminLogin'])->name('loginSubmit');

Route::group(['prefix' => 'admin'], function(){

    Route::get('/dashboard',[AdminController::class, 'AdminDashboard'])->name('admin.dashboard')->middleware('checkLoggedIn');
    Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout')->middleware('checkLoggedIn');

    Route::get('/register',[AdminController::class, 'AdminRegister'])->name('admin.register');

    // Route::get('/userAccount',[AdminController::class, 'AdminUserAccount'])->name('admin.userAccount')->middleware('checkLoggedIn');


    Route::get('/userAccountInfo',[UserAccountController::class, 'getUserAccountInfo'])->name('admin.userAccountInfo')->middleware('checkLoggedIn');

    Route::get('/viewAllService',[ServiceController::class, 'ViewAllServiceInfo'])->name('admin.viewAllServiceInfo')->middleware('checkLoggedIn');
    Route::get('/viewService/{id}/{from}',[ServiceController::class, 'ViewServiceInfo'])->name('admin.viewServiceInfo')->middleware('checkLoggedIn');
    Route::get('/approveService/{id}/{status}',[ServiceController::class, 'approveService'])->name('admin.approveService')->middleware('checkLoggedIn');

    Route::get('/viewAllCertificate',[CertificateController::class, 'ViewAllCertificateInfo'])->name('admin.viewAllCertificateInfo')->middleware('checkLoggedIn');
    Route::get('/viewCertificate/{id}',[CertificateController::class, 'ViewCertificateInfo'])->name('admin.viewCertificateInfo')->middleware('checkLoggedIn');

    Route::get('/viewAllPosts',[PostController::class, 'ViewAllPostsInfo'])->name('admin.viewAllPostsInfo')->middleware('checkLoggedIn');
    Route::get('/viewPost/{id}',[PostController::class, 'ViewPostInfo'])->name('admin.viewPostInfo')->middleware('checkLoggedIn');

    Route::get('/viewAllRefunds',[PaymentController::class, 'viewAllRefundList'])->name('admin.viewAllRefundsInfo')->middleware('checkLoggedIn');
    Route::get('/viewRefund/{id}',[PaymentController::class, 'ViewRefundInfo'])->name('admin.viewsRefundInfo')->middleware('checkLoggedIn');

    Route::get('/viewAllTransactions',[PaymentController::class, 'viewAllTransactionInfo'])->name('admin.viewAllTransactionInfo')->middleware('checkLoggedIn');
    Route::get('/viewTransaction/{id}',[PaymentController::class, 'ViewTransactionInfo'])->name('admin.viewTransactionInfo')->middleware('checkLoggedIn');

    Route::get('/viewOrder/{id}',[OrderController::class, 'viewOrderInfo'])->name('admin.viewOrderInfo')->middleware('checkLoggedIn');

    Route::get('/serviceApproval',[ServiceController::class, 'serviceApproval'])->name('admin.approval.service_approval')->middleware('checkLoggedIn');
    Route::get('/certificateApproval',[CertificateController::class, 'CertificateApproval'])->name('admin.approval.certificate_approval')->middleware('checkLoggedIn');
    Route::get('/viewCert/{id}',[CertificateController::class, 'ViewCertificateInfo2'])->name('admin.approval.viewCertInfo')->middleware('checkLoggedIn');
    Route::get('/approveCertificate/{id}/{status}',[CertificateController::class, 'approveCertificate'])->name('admin.approveCertificate')->middleware('checkLoggedIn');
    Route::get('/postApproval',[PostController::class, 'PostApproval'])->name('admin.approval.post_approval')->middleware('checkLoggedIn');
    Route::get('/viewPost2/{id}',[PostController::class, 'ViewPostInfo2'])->name('admin.approval.viewPostInfo')->middleware('checkLoggedIn');
    Route::get('/approvePost/{id}/{status}',[PostController::class, 'approveCertificate'])->name('admin.approvePost')->middleware('checkLoggedIn');
    Route::get('/paymentApproval',[PaymentController::class, 'PaymentApproval'])->name('admin.approval.payment_approval')->middleware('checkLoggedIn');
    Route::get('/approvePayment/{id}/{status}/{paymentType}',[PaymentController::class, 'approvePayment'])->name('admin.approvePayment')->middleware('checkLoggedIn');
    Route::post('/refundApproval/{id}',[PaymentController::class, 'approveRefund'])->name('admin.approval.refund_approval')->middleware('checkLoggedIn');
    Route::post('/transactionApproval/{id}',[PaymentController::class, 'transactionApproval'])->name('admin.approval.transaction_approval')->middleware('checkLoggedIn');
});

