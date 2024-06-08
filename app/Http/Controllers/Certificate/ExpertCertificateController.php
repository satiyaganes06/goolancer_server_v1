<?php

namespace App\Http\Controllers\Certificate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Certificate\ExpertCertificateLink;
use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Certificate\ExpertCertificate;

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

    public function getAllExpertCertificateListByExpertID(Request $request)
    {
        try {
            $certificateInfos = ExpertCertificate::where('ec_var_user_ref', $request->input('expertID'))
                ->get();
            return $this->sendResponse('get certificates details', '', $certificateInfos);

        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function addCertificate(Request $request)
    {
        try {
            $certificate = new ExpertCertificate();
            $certificate->ec_var_user_ref = $request->input('expertID');
            $certificate->ec_var_description = $request->input('description');
            $certificate->ec_var_registration_no = $request->input('certificateNo');
            $certificate->ec_var_title = $request->input('title');
            $certificate->ec_date_issue_date = $request->input('issueDate');
            if($request->input('expiryDate') != null){
                $certificate->ec_date_expiry_date = $request->input('expiryDate');
            }else{
                $certificate->ec_date_expiry_date = null;
            }
            $certificate->ec_var_image = $request->input('imageURL');
            $certificate->ec_int_status = 0;
            $certificate->save();

            return $this->sendResponse('Certificate added successfully', '', $certificate);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function updateCertificateDetails(Request $request)
    {
        try {
            $certificate = ExpertCertificate::find($request->input('certificateID'));
            $certificate->ec_var_description = $request->input('description');
            $certificate->ec_var_registration_no = $request->input('certificateNo');
            $certificate->ec_var_title = $request->input('title');
            $certificate->ec_date_issue_date = $request->input('issueDate');
            if($request->input('expiryDate') != null){
                $certificate->ec_date_expiry_date = $request->input('expiryDate');
            }
            if($request->input('imageURL') != null){
                $certificate->ec_var_image = $request->input('imageURL');
            }
            $certificate->ec_int_status = 0;
            $certificate->save();

            return $this->sendResponse('Certificate updated successfully', '', $certificate);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function deleteCertificate(Request $request)
    {
        try {
            $cert = ExpertCertificate::where('ec_int_ref', $request->input('certID'))->first();
            $certRequest = ExpertCertificateLink::where('ecl_int_ec_ref', $request->input('certID'))->first();
            $cert->delete();
            $certRequest->delete();

            return $this->sendResponse('Certificate deleted successfully', '', $cert);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }


}
