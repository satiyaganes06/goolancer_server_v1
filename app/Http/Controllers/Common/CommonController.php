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
            abort(404,$this->decode_data($filepath));
        }
    }

    public function imageViewer2(Request $request)
    {
        $path = storage_path($request->filepath);
        $contents = file_get_contents($path);
        $mime = mime_content_type($path);

        if (file_exists($path)) {
            // return response()->file($path);
            return Response::make($contents, 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline', // This header indicates to display the content inline (in the browser)
            ]);
        } else {
            abort(404,$this->decode_data($request->filepath));
        }
    }

    public function downloadFile($filepath)
    {
        $path = storage_path($this->decode_data($filepath));
        $contents = file_get_contents($path);
        $mime = mime_content_type($path);

        if (file_exists($path)) {
            return Response::make($contents, 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'attachment', // This header indicates to download the file
            ]);
        } else {
            abort(404,$this->decode_data($filepath));
        }
    }
}
