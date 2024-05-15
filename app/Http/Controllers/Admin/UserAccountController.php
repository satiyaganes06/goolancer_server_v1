<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\User\UserProfile;
use Illuminate\Support\Facades\DB;

class UserAccountController extends BaseController
{
    public function getUserAccountInfo()
    {

        //
        $clients = UserProfile::where('up_int_role', 0)->paginate(10);
        $experts = DB::table('user_profile')->where('up_int_role', '<>', 0)->paginate(10);

        return view('admin.user_account', compact('clients', 'experts'));
    }

    public function viewUserAccountInfo($id)
    {
        $user = UserProfile::where('up_int_ref',$id)->first();
        return view('admin.view_user_profile', compact('user'));
    }

}
