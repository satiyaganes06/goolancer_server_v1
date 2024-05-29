<?php

namespace App\Http\Controllers\Job;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Base\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\Booking\BookingRequest; // Import the missing class
use App\Models\Booking\BookingRequestImage;
use App\Models\Job\JobPayment;
use App\Models\Job\JobMain;
use App\Models\Job\JobResult;
use App\Models\Job\JobResultComment;
use App\Models\Job\JobResultFile;
use App\Models\Job\JobUserRating;
use App\Models\Post\ExpertPost;
use App\Models\Revenue\ExpertRevenueAccount;
use App\Http\Controllers\Auth\EmailController;


class JobController extends BaseController
{

    public function viewJobMainList(Request $request)
    {

        try {
            // Fetch booking requests
            $bookingRequests = BookingRequest::join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
                ->join('job_main', 'booking_request.br_int_ref', '=', 'job_main.jm_br_ref')
                ->where('br_var_up_ref', $request->input('userID'))
                ->select(
                    'booking_request.*',
                    'expert_service.es_var_user_ref as expertID',
                    'job_main.*'
                )
                ->get()->sortByDesc('jm_ts_created_at');

            // Fetch booking request images
            $bookingRequestImages = BookingRequestImage::whereIn('bri_br_ref', $bookingRequests->pluck('br_int_ref'))->get();

            // Group images by booking request
            $groupedImages = $bookingRequestImages->groupBy('bri_br_ref');

            // Add images to booking requests
            foreach ($bookingRequests as $bookingRequest) {
                $bookingRequest->imagesURL = $groupedImages[$bookingRequest->br_int_ref] ?? [];
            }

            return $this->sendResponse('get booking request details', '', $bookingRequests);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }

    public function getJobMainByID(Request $request)
    {
        try {
            $jobMain = JobMain::where('jm_int_ref', $request->input('jobMainID'))->first();

            return $this->sendResponse('get job main details', '', $jobMain);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }

    public function addJobPayment(Request $request)
    {
        try {
            $jobPayment = new JobPayment();
            $jobPayment->jp_jm_ref = $request->input('jobMainID');
            $jobPayment->jp_var_up_ref = $request->input('userID');
            $jobPayment->jp_int_type = $request->input('typeOfPayment');
            $jobPayment->jp_var_acount_transfer_name = $request->input('accountName');
            $jobPayment->jp_date_account_transfer_date = $request->input('accountDate');
            $jobPayment->jp_double_account_transfer_amount = $request->input('accountAmount');
            $jobPayment->jp_var_account_transfer_remark = $request->input('accountRemark');
            $jobPayment->jp_var_receipt = $request->input('image');
            $jobPayment->jp_int_status = 0;
            $jobPayment->save();

            return $this->sendResponse('add job payment', '', $jobPayment);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }

    public function getJobPaymentByJobMainID(Request $request)
    {
        try {
            $jobPayment = JobPayment::where('jp_jm_ref', $request->input('jobMainID'))
            ->where('jp_int_type',  $request->input('type'))
            ->orderBy('jp_ts_created_at', 'desc')->first();

            return $this->sendResponse('get job payment details', '', $jobPayment);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }
    
    public function uploadJobResultProgress(Request $request)
    {
        try {
            DB::beginTransaction();

            $jobResult = new JobResult();
            $jobResult->jr_jm_ref = $request->input('jobMainID');
            $jobResult->jr_int_delivery_item = $request->input('jrDeliveryItem');
            $jobResult->jr_double_progress_percent = $request->input('progressPercent');
            $jobResult->jr_int_status = 0;
            $jobResult->jr_txt_description = $request->input('desc');
            $jobResult->jr_ts_created_at = Date('Y-m-d H:i:s');
            $jobResult->save();

            $jobResult->save();

            if ($request->input('progressFiles') != null) {
                $files = json_decode($request->input('progressFiles'));

                foreach ($files as $file) {
                    $jobResultFile = new JobResultFile();
                    $jobResultFile->jrf_jr_ref = $jobResult->jr_int_ref;
                    $jobResultFile->jrf_files_path = $file;
                    $jobResultFile->save();
                }
            }
            
            if($request->input('jrDeliveryItem') == 1){
                JobMain::where('jm_int_ref', $request->input('jobMainID'))->update(
                    array(
                        'jm_int_status' => 1,
                    )
                );
            }

            DB::commit();

            
            if($request->input('jrDeliveryItem') == 1){
                            return $this->sendResponse('Succesfully delivered to your client', '', '');

            }
            return $this->sendResponse('Upload progress successfully', '', '');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }
    
    //Job Result
    public function getJobResultByJobMainID(Request $request)
    {
        try {

            // Fetch booking requests
            $jobResults = JobResult::where('jr_jm_ref', $request->input('jobMainID'))
            ->where('jr_int_delivery_item', 0)
            ->orderBy('jr_ts_created_at', 'desc')->get();

            // Fetch job result comments
            $jobResultComments = JobResultComment::whereIn('jrc_jr_ref', $jobResults->pluck('jr_int_ref'))->get();

            // Fetch job result file
            $jobResultFiles = JobResultFile::whereIn('jrf_jr_ref', $jobResults->pluck('jr_int_ref'))->get();

            // Group comments and files by job result ID
            $groupedComments = $jobResultComments->groupBy('jrc_jr_ref');
            $groupedFiles = $jobResultFiles->groupBy('jrf_jr_ref');

            // Iterate through job results and assign comments and files
            foreach ($jobResults as $jobResult) {
                $jobResult->jobComments = $groupedComments[$jobResult->jr_int_ref] ?? [];
                $jobResult->fileURL = $groupedFiles[$jobResult->jr_int_ref] ?? [];
            }



            return $this->sendResponse('get booking request details', '', $jobResults);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }

    //Job Result
    public function getJobResultDeliveryByJobMainID(Request $request)
    {
        try {

            // Fetch booking requests
            $jobResults = JobResult::where('jr_jm_ref', $request->input('jobMainID'))
            ->where('jr_int_delivery_item', 1)
            ->orderBy('jr_ts_created_at', 'desc')->get();

            // Fetch job result file
            $jobResultFiles = JobResultFile::whereIn('jrf_jr_ref', $jobResults->pluck('jr_int_ref'))->get();

            $groupedFiles = $jobResultFiles->groupBy('jrf_jr_ref');

            // Iterate through job results and assign comments and files
            foreach ($jobResults as $jobResult) {
                $jobResult->fileURL = $groupedFiles[$jobResult->jr_int_ref] ?? [];
            }



            return $this->sendResponse('get booking request details', '', $jobResults);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }

    public function addJobComment(Request $request)
    {
        try {
            $jobResultComment = new JobResultComment();
            $jobResultComment->jrc_jr_ref = $request->input('jobResultID');
            $jobResultComment->jrc_int_user_type = $request->input('userType');
            $jobResultComment->jrc_txt_comment = $request->input('comment');
            $jobResultComment->save();

            $result = JobResultComment::where('jrc_jr_ref', $request->input('jobResultID'))->get();

            return $this->sendResponse('add job comment', '', $result);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }
    
    public function getJobCommentByJobResultID(Request $request)
    {
        try {
            $jobResultComments = JobResultComment::where('jrc_jr_ref', $request->input('jobResultID'))->get();

            return $this->sendResponse('get job result comments', '', $jobResultComments);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }

    public function updateJobResultStatus(Request $request)
    {
        try {
            JobResult::where('jr_int_ref', $request->input('jobResultID'))->update(
                array(
                    'jr_int_status' => $request->input('status')
                )
            );

            $jobResult = JobResult::where('jr_int_ref', $request->input('jobResultID'))->first();

            return $this->sendResponse('updated successfully', '', $jobResult);
        } catch (\Throwable $th) {

            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function updateJobResultComplete(Request $request)
    {
        try {

            if ($request->input('status') == 0) {
                JobMain::where('jm_int_ref', $request->input('jobMainID'))->update(
                    array(
                        'jm_int_accept_result' => $request->input('status')
                    )
                );
            } else if ($request->input('status') == 2) {
                JobMain::where('jm_int_ref', $request->input('jobMainID'))->update(
                    array(
                        'jm_int_timeline_status' => $request->input('status')
                    )
                );

                JobMain::where('jm_int_ref', $request->input('jobMainID'))->update(
                    array(
                        'jm_int_accept_result' => 0
                    )
                );
            }else if($request->input('status') == 1){
                JobMain::where('jm_int_ref', $request->input('jobMainID'))->update(
                    array(
                        'jm_int_accept_result' => $request->input('status')
                    )
                );
            }


            return $this->sendResponse('updated successfully', '', '');
        } catch (\Throwable $th) {

            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getJobUserRating(Request $request){
        try {
            $jobUserRating = JobUserRating::where('jur_jm_ref', $request->input('jobMainID'))->first();

            return $this->sendResponse('get job user rating', '', $jobUserRating);

        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), '', 500);

        }
    }

    public function getUserRatingListByServiceID(Request $request){
        try {


            $jobUserRatings = JobUserRating::join('user_profile', 'job_user_rating.jur_var_up_ref', '=', 'user_profile.up_int_ref')
            ->where('jur_int_es_ref', $request->input('serviceID'))
            ->get();

            return $this->sendResponse('get job user rating', '', $jobUserRatings);

        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), '', 500);

        }
    }

    public function addJobUserRating(Request $request){
        try {
            $jobUserRating = new JobUserRating();
            $jobUserRating->jur_jm_ref = $request->input('jobMainID');
            $jobUserRating->jur_var_up_ref = $request->input('userID');
            $jobUserRating->jur_rating_point = $request->input('ratingPoint');
            $jobUserRating->jur_txt_comment = $request->input('comment');
            $jobUserRating->jur_int_es_ref = $request->input('expertServiceID');
            $jobUserRating->save();

            return $this->sendResponse('add job user rating', '', $jobUserRating);

        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), '', 500);

        }
    }

    public function getJobPaymentByExpertID(Request $request){
        try {
            $payments = JobPayment::join('job_main', 'job_payment.jp_jm_ref', '=', 'job_main.jm_int_ref')
            ->join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
            ->join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
            ->where('expert_service.es_var_user_ref', $request->input('expertID'))
            ->where('job_payment.jp_int_status', 1)
            ->orderBy('job_payment.jp_ts_created_at', 'desc')
            ->select('job_payment.*', 'job_main.*', 'booking_request.*', 'expert_service.*')
            ->get();

            return $this->sendResponse('get expert payments', '', $payments);

        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), '', 500);

        }
    }

    public function getJobMainNBookingReqByJobMainID(Request $request){
        try {


            $job = JobMain::join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
            ->where('job_main.jm_int_ref', $request->input('jobMainID'))
            ->select('job_main.*', 'booking_request.*')
            ->first();

            if ($job) {
                $bookingRequestImages = BookingRequestImage::where('bri_br_ref', $job->br_int_ref)->get();
                $job->imagesURL = $bookingRequestImages;
            }

            return $this->sendResponse('get job main and booking request', '', $job);

        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), '', 500);

        }
    }


    public function viewJobMainListForExpert(Request $request)
    {

        try {
            // Fetch booking requests
            $bookingRequests = BookingRequest::join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
                ->join('job_main', 'booking_request.br_int_ref', '=', 'job_main.jm_br_ref')
                ->where('expert_service.es_var_user_ref', $request->input('expertID'))
                ->select(
                    'booking_request.*',
                    'job_main.*',
                )
                ->get();

            // Fetch booking request images
            $bookingRequestImages = BookingRequestImage::whereIn('bri_br_ref', $bookingRequests->pluck('br_int_ref'))->get();

            // Group images by booking request
            $groupedImages = $bookingRequestImages->groupBy('bri_br_ref');

            // Add images to booking requests
            foreach ($bookingRequests as $bookingRequest) {
                $bookingRequest->imagesURL = $groupedImages[$bookingRequest->br_int_ref] ?? [];
            }

            return $this->sendResponse('get booking request details', '', $bookingRequests);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), '', 500);
        }
    }

    public function calcSummaryForExpertDashboard(Request $request){
        try {
            $jobMain = JobMain::join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
            ->join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
            ->where('expert_service.es_var_user_ref', $request->input('expertID'))
            ->select('job_main.*', 'booking_request.*', 'expert_service.*')
            ->get();

            $bookingRequest = BookingRequest::join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
            ->where('expert_service.es_var_user_ref', $request->input('expertID'))
            ->where('booking_request.br_int_status', 0)
            ->get();

            $totalBookingRequest = $bookingRequest->count();

            $totalJob = $jobMain->count();
            $totalJobMainStatus0 = $jobMain->where('jm_int_status', 0)->count();
            $totalJobMainStatus1 = $jobMain->where('jm_int_status', 1)->count();
            $totalJobMainStatus2 = $jobMain->where('jm_int_status', 2)->count();

            $revenue = ExpertRevenueAccount::where('era_up_var_ref',  $request->input('expertID'))->first();

            $totalEarning = $revenue->era_double_total_balance;
            $totalRating = JobUserRating::join('job_main', 'job_user_rating.jur_jm_ref', '=', 'job_main.jm_int_ref')
            ->join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
            ->join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
            ->where('expert_service.es_var_user_ref', $request->input('expertID'))
            ->avg('job_user_rating.jur_rating_point');


            $summary = array(
                'totalJob' => $totalJob,
                'totalBookingRequest' => $totalBookingRequest,
                'totalJobMainStatus0' => $totalJobMainStatus0,
                'totalJobMainStatus1' => $totalJobMainStatus1,
                'totalJobMainStatus2' => $totalJobMainStatus2,
                'totalEarning' => number_format($totalEarning, 2) ?? 0,
                'totalRating' => number_format($totalRating, 2) ?? 0,
            );

            return $this->sendResponse('get summary', '', $summary);

        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), '', 500);

        }
    }
    
}
