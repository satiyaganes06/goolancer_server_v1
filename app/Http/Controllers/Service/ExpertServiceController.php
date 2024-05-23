<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service\ExpertService;
use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Certificate\ExpertCertificateLink;
use App\Models\Post\ExpertPostLink;
use Illuminate\Support\Facades\DB;

class ExpertServiceController extends BaseController
{
    
    //
    public function getAllServiceList(Request $request)
    {

        try {
            $serviceList = ExpertService::where('es_int_status', 1)->get();

            return $this->sendResponse('get all service info', '', $serviceList);
        } catch (\Throwable $th) {

            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getAllServiceByID(Request $request)
    {
        try {
            $serviceList = ExpertService::where('es_int_ref', $request->input('serviceID'))->first();

            return $this->sendResponse('get all service info', '', $serviceList);
        } catch (\Throwable $th) {

            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getAllServiceByExpertID(Request $request)
    {
        try {
            $serviceList = ExpertService::where('es_var_user_ref', $request->input('expertID'))->get();

            return $this->sendResponse('get all service info', '', $serviceList);
        } catch (\Throwable $th) {

            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function addService(Request $request)
    {
        try {
            DB::beginTransaction();

            $service = new ExpertService();

            $service->es_var_user_ref = $request->input('expertID');
            $service->es_int_service_type_ref = $request->input('serviceTypeID');
            $service->es_var_images = $request->input('imageURL');
            $service->es_var_title = $request->input('title');
            $service->es_txt_description = $request->input('desc');
            $service->es_var_starting_price = $request->input('price');
            $service->es_estimate_delivery_time = $request->input('deliveryTime');
            $service->es_bool_isInHouseExpert = $request->input('isInHouseExpert');
            $service->es_fl_average_rating = $request->input('averageRating');
            $service->es_int_status = 0;
            $service->save();

            $certificate = json_decode($request->input('certificates'));

            foreach ($certificate as $cert) {
                $certLink = new ExpertCertificateLink();
                $certLink->ecl_int_es_ref = $service->es_int_ref;
                $certLink->ecl_int_ec_ref = $cert;
                $certLink->save();
            }

            if ($request->input('posts') != null) {
                $posts = json_decode($request->input('posts'));

                foreach ($posts as $post) {
                    $postLink = new ExpertPostLink();
                    $postLink->epl_int_es_ref = $service->es_int_ref;
                    $postLink->epl_int_ep_ref = $post;
                    $postLink->save();
                }
            }

            DB::commit();

            return $this->sendResponse('Service saved successfully', '', $service);
        } catch (\Throwable $th) {

            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }
}
