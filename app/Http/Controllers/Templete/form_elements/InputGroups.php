<?php

namespace App\Http\Controllers\Templete\form_elements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InputGroups extends Controller
{
  public function index()
  {
    return view('content.form-elements.forms-input-groups');
  }
}
