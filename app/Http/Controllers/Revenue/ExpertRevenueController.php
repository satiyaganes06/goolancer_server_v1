<?php

namespace App\Http\Controllers\Revenue;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service\ExpertService;
use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Certificate\ExpertCertificateLink;
use App\Models\Post\ExpertPostLink;
use App\Models\Revenue\ExpertRevenueAccount;
use App\Models\Revenue\TransactionHistory;
use Illuminate\Support\Facades\DB;

class ExpertRevenueController extends BaseController
{
    //
    public function addExpertRevenue(Request $request){
        try {

            $revenueAccount = new ExpertRevenueAccount();
            $revenueAccount->era_up_var_ref = $request->input('expertID');
            $revenueAccount->era_double_total_balance = 0;
            $revenueAccount->era_double_total_withdrawn = 0;
            $revenueAccount->save();

            return $this->sendResponse('', '', $revenueAccount);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getExpertRevenue(Request $request){
        try {
            $expertRevenue = ExpertRevenueAccount::where('era_up_var_ref', $request->input('expertID'))->first();
            return $this->sendResponse('', '', $expertRevenue);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getTransactionHistory(Request $request){
        try {
            $transactionHistory = TransactionHistory::where('th_up_var_ref', $request->input('expertID'))->get();
            return $this->sendResponse('', '', $transactionHistory);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function requestWithdrawal(Request $request){
        try {
          //  DB::beginTransaction();
            // $revenueAccount = ExpertRevenueAccount::where('era_up_var_ref', $request->input('expertID'))->first();
            // $revenueAccount->era_double_total_withdrawn = $revenueAccount->era_double_total_withdrawn + $request->input('amount');
            // $revenueAccount->save();

            $transactionHistory = new TransactionHistory();
            $transactionHistory->th_up_var_ref = $request->input('expertID');
       //     $transactionHistory->th_jm_int_ref = 0;
            $transactionHistory->th_int_transaction_type = 1;
       //     $transactionHistory->th_int_payment_proof = 0;
            $transactionHistory->th_double_amount = $request->input('amount');
            $transactionHistory->th_bank_name = $request->input('bankName');
            $transactionHistory->th_var_transfer_account_name = $request->input('accountName');
            $transactionHistory->th_int_transfer_account_num = $request->input('accountNum');
            $transactionHistory->th_status = 0;
            $transactionHistory->save();

        //    DB::commit();
            return $this->sendResponse('', 'Withdrawal request submitted successfully', '');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }
}
