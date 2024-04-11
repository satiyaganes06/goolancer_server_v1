<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Models\User\UserProfile;
use Exception;
use Nette\Schema\Expect;
use Illuminate\Support\Facades\Storage;

class UserDetailsController extends BaseController
{
    public function getUserProfileDetail(Request $request)
    {

        try {
            $userProfileDetails = UserProfile::where('up_int_ref', $request->input('userID'))->first();

            return $this->sendResponse('get user info', '', $userProfileDetails);
        } catch (Exception $e) {

            return $this->sendError('Error : ' . $e->getMessage(), 500);
        }
    }

    public function cpFirstTimeStatusCheck(Request $request)
    {

        try {
            $status = UserProfile::select('up_int_first_time_login')->where('up_var_emailaddress', $request->input('userEmail'))->first();

            return $this->sendResponse('User first time status', '', $status);
        } catch (Exception $e) {

            return $this->sendError('Error : ' . $e->getMessage(), 500);
        }
    }

    public function cpCompleteProfile(Request $request)
    {

        try {

            $validatorUser = Validator::make($request->all(), [
                'cpID' => 'required|integer',
                'cpAddress' => 'required|string|max:255',
                'cpZipCode' => 'required|integer',
                'cpState' => 'required|string|max:255'
            ]);

            UserProfile::where('up_int_ref', $request->input('cpID'))->update(
                array(
                    'up_var_address' => $request->input('cpAddress'),
                    'up_int_zip_code' => $request->input('cpZipCode'),
                    'up_var_state' => $request->input('cpState'),

                )
            );



            return $this->sendResponse('Successfully complete your profile', '');
        } catch (Exception $e) {

            return $this->sendError('Error : ' . $e->getMessage(), 500);
        }
    }

    public function updateProfileInfo(Request $request)
    {
        try {
            // if ($request->hasFile('imageLink') && $request->file('imageLink')->isValid()) {
            //      $imagePath =  $request->file('imageLink')->store('Images/ProfileImages');


              //  if ($imagePath) {
                    UserProfile::where('up_int_ref', $request->input('userID'))->update(
                        array(
                            'up_var_first_name' => $request->input('userFirstName'),
                            'up_var_last_name' => $request->input('userLastName'),
                            'up_var_nric' => $request->input('userNRIC'),
                            'up_var_email_contact' => $request->input('userEmail'),
                            'up_var_contact_no' => $request->input('userPhoneNumber'),
                            'up_var_address' => $request->input('userAddress'),
                            'up_int_zip_code' => $request->input('userZipCode'),
                            'up_var_state' => $request->input('userState'),
                            'up_var_pic_first_name' => $request->input('imageLink'),
                            'up_int_first_time_login' => $request->input('firstTime'),
                            'up_txt_desc' =>  $request->input('userDesc') != null ? $request->input('userDesc') : '',
                        )
                    );
                   // $url = Storage::url($imagePath);
                    return $this->sendResponse('Successfully complete your profile', '');
                // } else {
                //     return $this->sendError('Error while uploading image', '', 500);
                // }
            // } else {

            //     return $this->sendError('Fail to upload image', '', 500);
            // }
        } catch (Exception $e) {

            return $this->sendError('Error : ' . $e->getMessage(), 500);
        }
    }
}
