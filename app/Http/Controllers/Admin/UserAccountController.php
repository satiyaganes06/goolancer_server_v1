<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\User\UserProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Booking\BookingRequest;
use App\Models\Revenue\ExpertRevenueAccount;
use Faker\Provider\Base;
use PHPUnit\Event\Facade;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Validator;

class UserAccountController extends BaseController
{
    public function getUserAccountInfo()
    {

        //
        $clients = UserProfile::where('up_int_role', 0)->paginate(10);
        $experts = DB::table('user_profile')->where('up_int_role', '<>', 0)->paginate(10);



        return view('admin.user_account', compact('clients', 'experts'));
    }

    public function viewUserAccountInfo($id, $role)
    {
        if ($role == 0) {
            $user = UserProfile::where('up_int_ref', $id)->first();
            $orders = BookingRequest::join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
                ->join('job_main', 'booking_request.br_int_ref', '=', 'job_main.jm_br_ref')
                ->join('user_profile', 'booking_request.br_var_up_ref', '=', 'user_profile.up_int_ref')
                ->where('booking_request.br_var_up_ref', $id)
                ->select(
                    'booking_request.*',
                    'expert_service.es_var_user_ref as expertID',
                    'job_main.*'
                )
                ->get();

            return view('admin.view_user_profile', compact('user', 'orders'));
        } else {
            $orders = BookingRequest::join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
                ->join('job_main', 'booking_request.br_int_ref', '=', 'job_main.jm_br_ref')
                ->where('expert_service.es_var_user_ref', $id)
                ->select(
                    'booking_request.*',
                    'expert_service.es_var_user_ref as expertID',
                    'job_main.*'
                )
                ->get();

            $user = UserProfile::where('up_int_ref', $id)->first();
            return view('admin.view_user_profile', compact('user', 'orders'));
        }
    }

    public function addInHouseExpertViewController()
    {
        return view('admin.add_in_house_expert');
    }

    public function addInHouseExpertController(Request $request)
    {

        //$userAuthEmail = $request

        try {
            $factory = (new Factory)
                ->withServiceAccount(app()->basePath() . '/goolancer-edd89-firebase-adminsdk-sf7h2-bfb2657229.json')
                ->withDatabaseUri('https://goolancer-edd89.firebaseio.com');

            $createUser = $factory->createAuth()->createUserWithEmailAndPassword($request->input('email'), $request->input('password'));


            if ($createUser != null) {
                DB::beginTransaction();

                //  Link to firebase
                //  $request->input('password');

                // Insert into user_profile
                $userProfile = new UserProfile([
                    'up_int_ref' => $createUser->uid,
                    'up_var_first_name' => $request->input('first_name'),
                    'up_var_last_name' => $request->input('last_name'),
                    'up_var_nric' => $request->input('nric'),
                    'up_var_email_contact' => $request->input('email'),
                    'up_int_role' => 2,
                ]);
                $userProfile->save();


                $revenueAccount = new ExpertRevenueAccount();
                $revenueAccount->era_up_var_ref = $userProfile->up_int_ref;
                $revenueAccount->era_double_total_balance = 0.0;
                $revenueAccount->era_double_total_withdrawn = 0.0;
                $revenueAccount->era_double_deposit_queue = 0.0;
                $revenueAccount->save();


                DB::commit();

                $userProfileDetails = UserProfile::where('up_int_ref', $request->input('upID'))->first();
                return redirect()->back()->with('success', 'In-house expert added successfully');
            } else {
                $factory->createAuth()->deleteUser($createUser->uid);
                return redirect()->back()->withErrors('Error adding in-house expert')->withInput();
            }
        } catch (\Throwable $th) {
            $factory->createAuth()->deleteUser($createUser->uid);
            return redirect()->back()->withErrors($th->getMessage())->withInput();
        }
    }
}
