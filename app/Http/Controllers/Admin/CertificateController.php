<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Certificate\ExpertCertificate;
use App\Models\Service\ExpertService;

class CertificateController extends BaseController
{
    public function ViewAllCertificateInfo()
    {
        $certs = ExpertCertificate::where('ec_int_status', 1)->paginate(10);
        return view('admin.view_all_cert', compact('certs'));
    }

    public function ViewCertificateInfo($id)
    {
        $certificate = ExpertCertificate::find($id);
        return view('admin.view_cert', compact('certificate'));
    }

    public function ViewCertificateInfo2($id)
    {
        $certificate = ExpertCertificate::find($id);
        return view('admin.approval.view_cert', compact('certificate'));
    }

    public function CertificateApproval()
    {
        $certificates = ExpertCertificate::where('ec_int_status', 0)->paginate(10);
        return view('admin.approval.cert_approval', compact('certificates'));
    }

    public function approveCertificate($id, $status)
    {
        $certificate = ExpertCertificate::find($id);
        $certificate->ec_int_status = $status;
        $certificate->save();

        $certificates = ExpertCertificate::where('ec_int_status', 0)->paginate(10);

        return redirect()->route('admin.approval.certificate_approval', compact('certificates'));
    }

}
