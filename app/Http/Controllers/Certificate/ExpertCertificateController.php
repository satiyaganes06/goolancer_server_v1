<?php

namespace App\Http\Controllers\Certificate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Certificate\ExpertCertificateLink;
use App\Http\Controllers\Base\BaseController as BaseController;

class ExpertCertificateController extends BaseController
{
    public function getExpertCertificateByService(Request $request)
    {
        try {
            $certificateInfos = ExpertCertificateLink::join('expert_certificate', 'expert_cert_link.ecl_int_ec_ref', '=', 'expert_certificate.ec_int_ref')
                ->where('ecl_int_es_ref', $request->input('serviceID'))
                ->select('expert_certificate.*')
                ->get();
            return $this->sendResponse('get certificates details', '', $certificateInfos);

        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }


}
