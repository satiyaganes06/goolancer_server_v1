<?php

namespace App\Http\Controllers\Templete\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiscError extends Controller
{
  public function index()
  {
    return view('content.pages.pages-misc-error');
  }
}
