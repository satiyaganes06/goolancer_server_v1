<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Booking\BookingRequest; // Import the missing class
use App\Models\Booking\BookingRequestImage;
use App\Models\Booking\BookingRequestNegotiation;
use Illuminate\Support\Facades\DB;

class BookingRequestController extends BaseController
{
    public function addBookingRequest(Request $request)
    {
        try {


            DB::beginTransaction();

            $bookingRequest = new BookingRequest;

            $bookingRequest->br_var_up_ref = $request->input('br_var_up_ref');
            $bookingRequest->br_int_es_ref = $request->input('br_int_es_ref');
            $bookingRequest->br_var_title = $request->input('br_var_title');
            $bookingRequest->br_txt_desc = $request->input('br_txt_desc');
            $bookingRequest->br_var_address = $request->input('br_var_address');
            $bookingRequest->br_int_zip_code = $request->input('br_int_zip_code');
            $bookingRequest->br_var_state = $request->input('br_var_state');
            $bookingRequest->br_double_price = $request->input('br_double_price');
            $bookingRequest->br_var_delivery_time = $request->input('br_var_delivery_time');

            $bookingRequest->save();

            $images = json_decode($request->input('requestImage'));

            foreach ($images as $image) {
                $bookingRequestImage = new BookingRequestImage;
                $bookingRequestImage->bri_br_ref = $bookingRequest->br_int_ref;
                $bookingRequestImage->bri_booking_image = $image;
                $bookingRequestImage->save();
            }

            DB::commit();

            return $this->sendResponse('Your request send to expert successfully.', '');
        } catch (\Throwable $th) {

            return $this->sendError($th->getMessage(), '', 500);
        }
    }

    public function viewBookingRequest(Request $request)
    {

        try {
            // Fetch booking requests
            $bookingRequests = BookingRequest::join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
            ->where('br_var_up_ref', $request->input('userID'))
            ->select(
                'booking_request.*',
                'expert_service.es_var_user_ref as expertID'
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

    public function getBookingRequestNegotiation(Request $request){
        try {
            $negotiationList = BookingRequestNegotiation::where('brn_br_int_ref', $request->input('bookingRequestID'))->get();

            return $this->sendResponse('get all negotiation info', '', $negotiationList);
        } catch (\Throwable $th) {

            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function updateBookingRequestNegotiationStatus(Request $request){
        try {
            BookingRequestNegotiation::where('brn_int_ref ', $request->input('bookingRequestNegoID'))->update(
                array(
                    'brn_int_status' => $request->input('status')
                )
            );


            return $this->sendResponse('updated successfully', '', '');
        } catch (\Throwable $th) {

            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }
}
