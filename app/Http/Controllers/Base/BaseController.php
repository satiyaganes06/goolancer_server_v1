<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class BaseController extends Controller
{
    public function sendResponse($message, $token, $result = '')
    {
        $response = [
            'success' => true,
            'message' => $message,
            'token' => $token
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }

        // $ul = $this->encode_data($response);
        return response()->json($response, 200);
    }

    public function sendError($errorMEssage, $code)
    {
        $response = [
            'success' => false,
            'message' => $errorMEssage,
        ];

        // if(!empty($errorMEssage)){
        //     $response['data'] = $errorMEssage;
        // }

        return response()->json($response, $code);
    }

    public function encode_data($data)
    {
        $encURI = urlencode($data);
        return str_split($encURI);
    }

    public function decode_data($data)
    {
        $decData = urldecode($data);
        $decData = base64_decode($decData);
        return $decData;
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required', // Adjust the file size limit as needed
            ]);

            $file = $request->file('file');

            if ($request->input('whr') == 'UserProfileImage') {
                // 'pdfs' is the storage folder, you can change it as needed
                $path = $file->store('app/uploads/images/UserProfileImage');
            } else if ($request->input('whr') == 'PostImage') {
                $path = $file->store('app/uploads/images/PostImage');
            } else if ($request->input('whr') == 'CertificateDocument') {
                $path = $file->store('app/uploads/images/CertificateDocument');
            } else if ($request->input('whr') == 'ServiceImage') {
                $path = $file->store('app/uploads/images/ServiceImage');
            } else if ($request->input('whr') == 'ServiceDocument') {
                $path = $file->store('app/uploads/images/ServiceDocument');
            } else if ($request->input('whr') == 'ServiceRequestImage') {
                $path = $file->store('app/uploads/images/ServiceRequestImage');
            } else if ($request->input('whr') == 'PaymentReceipt') {
                $path = $file->store('app/uploads/images/PaymentReceipt');
            } else if ($request->input('whr') == 'JobResultFile') {
                $path = $file->store('app/uploads/images/JobResultFile');
            } else {
                $path = $file->store('app/uploads/images');
            }
            //    // $path = $file->store('uploads/images/profile'); // 'pdfs' is the storage folder, you can change it as needed
            // $path = $file->store('uploads/images'); // 'pdfs' is the storage folder, you can change it as needed
            // //  $path = Storage::disk('local')->put('uploads/documents', $pdf);

            return $this->sendResponse('Send succeffully',  $path, '');
        } catch (Exception $e) {
            return $this->sendError('Error : ' . $e->getMessage(), 500);
        }
    }


    // public function getCpProfileDetails($userLoginID){
    //     $userLoginDetails = UserLogin::where('ul_int_ref', $userLoginID)->value('ul_int_profile_ref');

    //     return $userLoginDetails;
    // }
}
