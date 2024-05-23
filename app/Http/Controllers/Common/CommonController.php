<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class CommonController extends BaseController
{
    public function imageViewer($filepath)
    {
    //    dd($this->decode_data($filepath));
        $path = storage_path($this->decode_data($filepath));
        $contents = file_get_contents($path);
        $mime = mime_content_type($path);

        if (file_exists($path)) {
            // return response()->file($path);
            return Response::make($contents, 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline', // This header indicates to display the content inline (in the browser)
            ]);
        } else {

            $path1 = storage_path('app/uploads/images/CertificateDocument/504708-200.png');
            $contents1 = file_get_contents($path1);
            $mime1 = mime_content_type($path1);
            
            return Response::make($contents1, 200, [
                'Content-Type' => $mime1,
                'Content-Disposition' => 'inline', // This header indicates to display the content inline (in the browser)
            ]);
        }

    }


    public function displayImage($app, $uploads, $folder, $category, $filename)
    {
        $path = storage_path($app. '/' .$uploads . '/' . $folder. '/' .$category. '/' .$filename);
        $contents = file_get_contents($path);
        $mime = mime_content_type($path);
//app/uploads/images/JobResultFile/welcome2.png
        try {
            if (file_exists($path)) {
                // return response()->file($path);
                return Response::make($contents, 200, [
                    'Content-Type' => $mime,
                    'Content-Disposition' => 'inline', // This header indicates to display the content inline (in the browser)
                ]);
            } 
        } catch (\Throwable $e) {
            return $this->sendError('Error : ' . $e->getMessage(). ' Path: '. $this->decode_data($path), 500);
        }
    }
}
