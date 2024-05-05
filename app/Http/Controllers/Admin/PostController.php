<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Certificate\ExpertCertificate;
use App\Models\Post\ExpertPost;
use App\Models\Service\ExpertService;

class PostController extends BaseController
{
    public function ViewAllPostsInfo()
    {
        $posts = ExpertPost::where('ep_int_status', 1)->paginate(10);
        return view('admin.view_all_post', compact('posts'));
    }

    public function ViewPostInfo($id)
    {
        $post = ExpertPost::find($id);
        return view('admin.view_post', compact('post'));
    }

    public function ViewPostInfo2($id)
    {
        $post = ExpertPost::find($id);
        return view('admin.approval.view_post', compact('post'));
    }

    public function PostApproval()
    {
        $posts = ExpertPost::paginate(10);
        return view('admin.approval.post_approval', compact('posts'));
    }

    public function approveCertificate($id, $status)
    {
        $post = ExpertPost::find($id);
        $post->ep_int_status = $status;
        $post->save();

        $posts = ExpertPost::where('ep_int_status', 0)->paginate(10);

        return redirect()->route('admin.approval.post_approval', compact('posts'));
    }

}
