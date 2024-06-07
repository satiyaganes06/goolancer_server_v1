<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Job\JobMain;
use App\Models\Job\JobPayment;
use App\Models\Revenue\RefundRequest;
use App\Models\User\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AdminController extends BaseController
{
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLogin()
    {
        return view('admin.auth.login');
    }

    public function AdminRegister()
    {
        return view('admin.auth.register');
    }

    public function AdminUserAccount()
    {
        return view('admin.user_account');
    }

    public function GenerateReport()
    {
        //Generate total number of client and expert registered in the last 5 days
        $experts = UserProfile::where('up_int_role', 1)->where('up_ts_created_at', '>=', Carbon::now()->subDays(5))->count();

        $clients = UserProfile::where('up_int_role', 0)->where('up_ts_created_at', '>=', Carbon::now()->subDays(5))->count();


        $clientsTotal = UserProfile::where('up_int_role', 0)->count();
        $expertsTotal = UserProfile::where('up_int_role', 1)->count();

        //Total job payment
        $totalJobPayment = JobPayment::where('jp_int_status', 1)->sum('jp_double_account_transfer_amount');
        $totalPendingJobPayment = JobPayment::where('jp_int_status', 0)->sum('jp_double_account_transfer_amount');

        //Total Pending refund
        $totalPendingRefund = RefundRequest::where('rr_int_status', 0)->sum('rr_double_amount');

        //New job main
        $newJobMain = JobMain::where('jm_int_status', 0)->where('jm_ts_created_at', '>=', Carbon::now()->subDays(5))->count();


        //Revenue by month
        // Retrieve the data for the past 30 days
        $today = now();
        $past30Days = $today->subDays(30);

        $payments = JobPayment::select(
            DB::raw('DATE(jp_ts_created_at) as created_date'),
            DB::raw('SUM(jp_double_account_transfer_amount) as total_amount')
        )
            ->where('jp_ts_created_at', '>=', $past30Days)  // Filter for last 30 days
            ->groupBy('created_date')
            ->get();

        // You can further process the data if needed
        $labels = $payments->pluck('created_date');
        $amounts = $payments->pluck('total_amount');

        return view('admin.index', compact('clients', 'experts', 'clientsTotal', 'expertsTotal', 'totalJobPayment', 'totalPendingJobPayment', 'totalPendingRefund', 'newJobMain', 'labels', 'amounts'));
        // return $this->sendResponse('User registered successfully.', '', [
        //     'experts' => $experts,
        //     'clients' => $clients,
        //     'clientsTotal' => $clientsTotal,
        //     'expertsTotal' => $expertsTotal,
        //     'totalJobPayment' => $totalJobPayment,
        //     'totalPendingJobPayment' => $totalPendingJobPayment,
        //     'totalPendingRefund' => $totalPendingRefund
        // ], 200);

    }
}
