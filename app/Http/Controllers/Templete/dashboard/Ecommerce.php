<?php

namespace App\Http\Controllers\Templete\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Ecommerce extends Controller
{
    public function index(){
      return view('content.dashboard.dashboards-ecommerce');
    }
}
