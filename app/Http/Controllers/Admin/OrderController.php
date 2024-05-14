<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Certificate\ExpertCertificate;
use App\Models\Service\ExpertService;
use App\Models\Job\JobMain;
use App\Models\Job\JobPayment;
use App\Models\Job\JobResult;
use App\Models\Job\JobResultComment;
use App\Models\Job\JobResultFile;
use App\Models\Job\JobUserRating;
use App\Models\Booking\BookingRequest;
use App\Models\Booking\BookingRequestImage;
use App\Models\User\UserProfile;

class OrderController extends BaseController
{
    public function ViewAllCertificateInfo()
    {
        $certs = ExpertCertificate::where('ec_int_status', 1)->paginate(10);
        return view('admin.view_all_cert', compact('certs'));
    }

    public function viewOrderInfo($jobMainID)
    {
        $jobMain = JobMain::where('jm_int_ref', $jobMainID)->first();
        $bookingRequests = $this->getBookingRequestByID($jobMain->jm_br_ref);
        $jobPaymentInitial = JobPayment::where('jp_jm_ref', $jobMainID)
            ->where('jp_int_type',  0)
            ->orderBy('jp_ts_created_at', 'desc')->first();
        $jobPaymentComplete = JobPayment::where('jp_jm_ref', $jobMainID)
            ->where('jp_int_type',  1)
            ->orderBy('jp_ts_created_at', 'desc')->first();

        $jobResults = $this->getJobResultCommentByJobMainID($jobMainID);
        $jobResultsDeliverys = $this->getJobResultDeliveryByJobMainID($jobMainID);

        $jobUserRating = JobUserRating::where('jur_jm_ref', $jobMainID)->first();
        $clientDetails = UserProfile::where('up_int_ref', $bookingRequests[0]->br_var_up_ref)->first();

        return view('admin.view_order', compact('jobMain', 'bookingRequests', 'jobPaymentInitial', 'jobPaymentComplete', 'jobResults', 'jobResultsDeliverys', 'jobUserRating', 'clientDetails'));
    }

    public function getJobResultCommentByJobMainID($jobMainID)
    {
        $jobResults = JobResult::where('jr_jm_ref', $jobMainID)
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
        return $jobResults;
    }

    public function getJobResultDeliveryByJobMainID($jobMainID)
    {
        $jobResultsDeliverys = JobResult::where('jr_jm_ref', $jobMainID)
            ->where('jr_int_delivery_item', 1)
            ->orderBy('jr_ts_created_at', 'desc')->get();

        // Fetch job result file
        $jobResultFiles = JobResultFile::whereIn('jrf_jr_ref', $jobResultsDeliverys->pluck('jr_int_ref'))->get();

        $groupedFiles = $jobResultFiles->groupBy('jrf_jr_ref');

        // Iterate through job results and assign comments and files
        foreach ($jobResultsDeliverys as $jobResult) {
            $jobResult->fileURL = $groupedFiles[$jobResult->jr_int_ref] ?? [];
        }

        return $jobResultsDeliverys;
    }

    public function getBookingRequestByID($id)
    {
        $bookingRequests = BookingRequest::where('br_int_ref', $id)->get();

        // Fetch booking request images
        $bookingRequestImages = BookingRequestImage::whereIn('bri_br_ref', $bookingRequests->pluck('br_int_ref'))->get();

        // Group images by booking request
        $groupedImages = $bookingRequestImages->groupBy('bri_br_ref');

        // Add images to booking requests
        foreach ($bookingRequests as $bookingRequest) {
            $bookingRequest->imagesURL = $groupedImages[$bookingRequest->br_int_ref] ?? [];
        }

        return $bookingRequests;
    }
}
