<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Base\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User\UserProfile;
use App\Models\User\UserLogin;
use App\Models\User\RoleValidity;
use Laravel\Sanctum\PersonalAccessToken;
use Exception;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Revenue\ExpertRevenueAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AuthController extends BaseController
{
    // public function __construct()
    // {
    //     $this->middleware('auth')->except('login');
    // }

    public function register(Request $request)
    {
        try {
            // $user = UserLogin::where('ul_var_emailaddress', $request->input('upEmailContact'))->first();

            // if ($user) {
            //     return $this->sendError('Email already exists', 500);

            // } else {

            try {

                $validatorUser = Validator::make($request->all(), [
                    'upfirstName' => 'required|string|max:255',
                    'upLastName' => 'required|string|max:255',
                    'upNric' => 'required|string|max:255',
                    'upEmailContact' => 'required|string|max:255',
                    'ulPassword' => 'required|min:6'
                ]);

                if ($validatorUser->fails()) {

                    return $this->sendError('Error : ' . $validatorUser->errors(), 500);
                }
                // $validated = $request->validated();
                DB::beginTransaction();

                // Insert into user_profile
                $userProfile = new UserProfile([
                    'up_int_ref' => $request->input('upID'),
                    'up_var_first_name' => $request->input('upfirstName'),
                    'up_var_last_name' => $request->input('upLastName'),
                    'up_var_nric' => $request->input('upNric'),
                    'up_var_email_contact' => $request->input('upEmailContact'),
                    'up_int_role' => $request->input('upRole'),
                ]);
                $userProfile->save();

                if($request->input('upRole') == 1 || $request->input('upRole') == 2){
                    $revenueAccount = new ExpertRevenueAccount();
                    $revenueAccount->era_up_var_ref = $request->input('upID');
                    $revenueAccount->era_double_total_balance = 0.0;
                    $revenueAccount->era_double_total_withdrawn = 0.0;
                    $revenueAccount->save();
                }

                DB::commit();

                $userProfileDetails = UserProfile::where('up_int_ref', $request->input('upID'))->first();

                return $this->sendResponse('User registered successfully.', '', $userProfileDetails);
            } catch (\Exception $e) {

                DB::rollBack();
                //return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
                return $this->sendError('Error : ' . $e->getMessage(), 500);
            }
            //}

        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function adminLogin(Request $request)
    {
         // Validate the form data
         $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the entered credentials match the hardcoded credentials
        if ($request->email === 'admin@gmail.com' && $request->password === 'Pa$$w0rd') {
            // Authentication passed
            Session::put('loggedIn', true); // Set a session variable to indicate that the user is logged in
            return redirect()->intended('/admin/dashboard'); // Redirect to dashboard or any other page
        } else {
            // Authentication failed
            return back()->withInput()->withErrors(['email' => 'Invalid credentials']);
        }
    }


    public function adminLogout()
    {
        Session::forget('loggedIn'); // Remove the loggedIn session variable
        return redirect()->route('login'); // Redirect to the login page

    }
}

// public function register(){

//     $model =  RoleLogin::all();

//     return view('test.model', ['model' => $model]);
// }
