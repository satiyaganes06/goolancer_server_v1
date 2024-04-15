<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommonController extends Controller
{
    public function show($filename)
    {
        // Assuming your images are stored in the public/images directory
        $path = public_path('images/' . $filename);

        // Check if the file exists
        if (!Storage::exists($path)) {
            abort(404);
        }

        // Return the image with proper content type
        $file = Storage::get($path);
        $type = Storage::mimeType($path);
        $response = response($file, 200)->header('Content-Type', $type);

        return $response;
    }

    public function displayImage($imagePath)
    {
        return view('image_viewer')->with('imagePath', $imagePath);
    }
}
