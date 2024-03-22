<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service\ExpertService;
use App\Http\Controllers\Base\BaseController as BaseController;

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

}
