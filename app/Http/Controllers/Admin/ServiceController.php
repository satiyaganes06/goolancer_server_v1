<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Service\ExpertService;
use App\Models\User\UserProfile;
use App\Models\Certificate\ExpertCertificateLink;
use App\Models\Post\ExpertPostLink;


class ServiceController extends BaseController
{
    public function ViewAllServiceInfo()
    {
        $services = ExpertService::where('es_int_status', 1)->paginate(10);
        return view('admin.view_all_service', compact('services'));
    }

    public function ViewServiceInfo($id, $from)
    {
        $service = ExpertService::find($id);
        $experts = UserProfile::where('up_int_ref', $service->es_var_user_ref)->first();
        $certificates = ExpertCertificateLink::join('expert_certificate', 'expert_cert_link.ecl_int_ec_ref', '=', 'expert_certificate.ec_int_ref')
            ->where('ecl_int_es_ref', $service->es_int_ref)
            ->select('expert_certificate.*')
            ->get();
        $posts = ExpertPostLink::join('expert_post', 'expert_post_link.epl_int_ep_ref', '=', 'expert_post.ep_int_ref')
            ->where('epl_int_es_ref', $service->es_int_ref)
            ->select('expert_post.*')
            ->get();

        return view('admin.view_service', compact('service', 'experts', 'certificates', 'posts', 'from'));
    }

    public function serviceApproval()
    {
        $services = ExpertService::where('es_int_status', 0)->paginate(10);
        return view('admin.approval.service_approval', compact('services'));
    }

    public function approveService($id, $status)
    {
        $service = ExpertService::find($id);
        $service->es_int_status = $status;
        $service->save();

        $services = ExpertService::where('es_int_status', 0)->paginate(10);

        return redirect()->route('admin.approval.service_approval', compact('services'));
    }
}
