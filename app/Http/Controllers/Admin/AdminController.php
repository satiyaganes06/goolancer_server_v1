<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;


class AdminController extends BaseController
{
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLogin()
    {
        return view('admin.auth.login');
    }

    public function AdminRegister()
    {
        return view('admin.auth.register');
    }

    public function AdminUserAccount()
    {
        return view('admin.user_account');
    }
}
