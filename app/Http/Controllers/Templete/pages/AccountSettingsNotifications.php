<?php

namespace App\Http\Controllers\Templete\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountSettingsNotifications extends Controller
{
  public function index()
  {
    return view('content.pages.pages-account-settings-notifications');
  }
}
