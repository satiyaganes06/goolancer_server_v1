<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Kreait\Firebase\Factory;


class NotificationController extends Controller
{
    public function sendNotification($message, $token){
       
    //     $factory = (new Factory())->withServiceAccount(app()->basePath().'goolancer-edd89-firebase-adminsdk-sf7h2-99970f72ad.json')
    //         ->withDatabaseUri('https://mydatabase.firebaseio.com');

    //    // $ul = $this->encode_data($response);
    //     return response()->json($response, 200);
    }

   
}
