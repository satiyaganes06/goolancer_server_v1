<?php

namespace App\Http\Controllers\Templete\layouts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithoutNavbar extends Controller
{
  public function index()
  {
    return view('content.layouts-example.layouts-without-navbar');
  }
}
