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

    public function getAllExpertPost2(Request $request)
    {
        try {
            $posteInfos = ExpertPost::join('user_profile', 'expert_post.ep_var_user_ref', '=', 'user_profile.up_int_ref')
            ->where('ep_int_status', 1)
            ->where('expert_post.ep_var_user_ref', '!=', $request->input('expertID'))
                ->get();
            return $this->sendResponse('get post details 2', '', $posteInfos);

        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getAllExpertPosts(Request $request)
    {
        try {
            $posteInfos = ExpertPost::where('ep_var_user_ref', $request->input('expertID'))
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

    public function addPost(Request $request)
    {
        try {
            $post = new ExpertPost();
            $post->ep_var_user_ref = $request->input('expertID');
            $post->ep_txt_desc = $request->input('description');
            $post->ep_var_image = $request->input('image');
            $post->ep_int_service_category = $request->input('serviceCategory');
            $post->ep_int_status = 1;
            $post->save();

            if($request->input('serviceID') != null){
                $postLink = new ExpertPostLink();
                $postLink->epl_int_ep_ref = $post->ep_int_ref;
                $postLink->epl_int_es_ref = $request->input('serviceID');
                $postLink->save();
            }

            return $this->sendResponse('Post added successfully', '', $post);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function deletePost(Request $request)
    {
        try {
            $post = ExpertPost::where('ep_int_ref', $request->input('postID'))->first();
            $postRequest = ExpertPostLink::where('epl_int_ep_ref', $request->input('postID'))->first();
            $post->delete();
            $postRequest->delete();
            return $this->sendResponse('Post deleted successfully', '', $post);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }
}
