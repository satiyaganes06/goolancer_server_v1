<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Base\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post\ExpertPost;
use App\Models\Post\ExpertPostLink;
use App\Models\User\UserProfile;

class ExpertPostController extends BaseController
{
    //
    public function getExpertPostByService(Request $request)
    {
        try {
            $posteInfos = ExpertPostLink::join('expert_post', 'expert_post_link.epl_int_ep_ref', '=', 'expert_post.ep_int_ref')
                ->where('epl_int_es_ref', $request->input('serviceID'))
                ->select('expert_post.*')
                ->get();
            return $this->sendResponse('get post details', '', $posteInfos);

        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getAllExpertPost(Request $request)
    {
        try {
            $posteInfos = ExpertPost::join('user_profile', 'expert_post.ep_var_user_ref', '=', 'user_profile.up_int_ref')
            ->where('ep_int_status', 1)
            ->where('ep_var_user_ref', '!=', $request->input('expertID'))
                ->get();
            return $this->sendResponse('get post details', '', $posteInfos);

        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getAllExpertPostByServiceCategory(Request $request)
    {
        try {
            $posteInfos = ExpertPost::join('user_profile', 'expert_post.ep_var_user_ref', '=', 'user_profile.up_int_ref')
            ->where('ep_int_status', 1)
            ->where('ep_var_user_ref', '!=', $request->input('expertID'))
            ->where('ep_int_ref', '!=', $request->input('postID'))
            ->where('ep_int_service_category', $request->input('serviceID'))
                ->get();
            return $this->sendResponse('get post details', '', $posteInfos);

        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }
}
