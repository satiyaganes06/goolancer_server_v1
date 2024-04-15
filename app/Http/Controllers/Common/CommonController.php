<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function imageViewer(Request $request)
    {
        $sss = $request->input('filepath');
        $path = storage_path("images/{$sss}");

        if (file_exists($path)) {
            dd($path);
            return response()->file($path);
        } else {
            abort(404);
        }
    }
}
