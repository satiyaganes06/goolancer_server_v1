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
use App\Models\Revenue\RefundRequest;
use App\Models\Job\JobMain;
use App\Models\Job\JobResult;
use Illuminate\Support\Facades\DB;

class ExpertRevenueController extends BaseController
{
    //
    public function addExpertRevenue(Request $request)
    {
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

    public function getExpertRevenue(Request $request)
    {
        try {
            $expertRevenue = ExpertRevenueAccount::where('era_up_var_ref', $request->input('expertID'))->first();
            return $this->sendResponse('', '', $expertRevenue);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getTransactionHistory(Request $request)
    {
        try {
            $transactionHistory = DB::select(
                'SELECT 
                    th.*
                FROM 
                    transaction_history th
                JOIN 
                    job_main jm ON th.th_jm_int_ref = jm.jm_int_ref
                JOIN 
                    booking_request br ON jm.jm_br_ref = br.br_int_ref
                JOIN 
                    expert_service es ON br.br_int_es_ref = es.es_int_ref
                WHERE 
                    es.es_var_user_ref = :expertId
                    AND th.th_status IN (0, 1)',
                ['expertId' => $request->input('expertID')]
            );


            // $transactionHistory = TransactionHistory::where('th_up_var_ref', $request->input('expertID'))->get();
            return $this->sendResponse('', '', $transactionHistory);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getTransactionHistoryByUserID(Request $request)
    {
        try {
            $transactionHistory = TransactionHistory::where('th_up_var_ref', $request->input('userID'))
                ->where('th_jm_int_ref', $request->input('jobMainID'))
                ->whereIn('th_int_transaction_type', [2, 3])
                ->first();
            return $this->sendResponse('', '', $transactionHistory);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function requestWithdrawal(Request $request)
    {
        try {
            /**  FIX ME!!! Its not add/remove from the expert_revenue_account  */


            //  DB::beginTransaction();
            // $revenueAccount = ExpertRevenueAccount::where('era_up_var_ref', $request->input('expertID'))->first();
            // $revenueAccount->era_double_total_withdrawn = $revenueAccount->era_double_total_withdrawn + $request->input('amount');
            // $revenueAccount->save();

            //  $jobMain = TransactionHistory::where('th_up_var_ref', $request->input('expertID'))->first();


            $transactionHistory = new TransactionHistory();
            $transactionHistory->th_up_var_ref = $request->input('expertID');
            $transactionHistory->th_jm_int_ref = $jobMain->th_jm_int_ref ?? 0;
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

    public function refundRequest(Request $request)
    {
        try {
            $refundRequest = new RefundRequest();
            $refundRequest->rr_jm_ref = $request->input('jobMainID');
            $refundRequest->rr_var_reason = $request->input('reason');
            $refundRequest->rr_double_amount = $request->input('amount');
            $refundRequest->rr_int_status = 0;
            $refundRequest->save();

            JobMain::where('jm_int_ref', $request->input('jobMainID'))->update(
                array(
                    'jm_int_status' => 2
                )
            );


            return $this->sendResponse('', 'Refund request submitted successfully', '');
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function getRefundDetailsByJobMainID(Request $request)
    {
        try {
            $refundDetails = RefundRequest::where('rr_jm_ref', $request->input('jobMainID'))->first();
            return $this->sendResponse('', '', $refundDetails);
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function penaltyPayment(Request $request)
    {
        try {
            TransactionHistory::where('th_int_ref', $request->input('transactionID'))->update(
                array(
                    'th_int_payment_proof' => $request->input('proof'),
                    'th_var_transfer_account_name' => $request->input('accountName'),
                    'th_int_transfer_account_num' => $request->input('accountNum'),

                )
            );

            return $this->sendResponse('', 'Penalty payment submitted successfully', '');
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function checkTransactionType(Request $request)
    {
        try {
            $transactions = TransactionHistory::where('th_up_var_ref', $request->input('clientID'))->get();

            foreach ($transactions as $transaction) {
                if ($transaction->th_int_transaction_type == 3 && $transaction->th_status == 0) {
                    return $this->sendResponse('true', '', '');
                }
            }

            return $this->sendResponse('false', '', '');

            // if ($transactions->contains('th_int_transaction_type', 3) && $transactions->contains('th_int_status', 4)) {

            //      return $this->sendResponse('true', '', '');
            // } else {
            //     return $this->sendResponse('false', '', '');
            // }
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }

    public function completeDelivery(Request $request)
    {
        try {
            $revenue = ExpertRevenueAccount::where('era_up_var_ref',  $request->input('expertID'))->first();
            $revenue->era_double_deposit_queue = $revenue->era_double_deposit_queue - $request->input('price');
            $revenue->era_double_total_balance = $revenue->era_double_total_balance + $request->input('price');
            $revenue->save();

            $jobResult = JobResult::find($request->input('jrCompleteID'));
            $jobResult->jr_double_progress_percent = 100;
            $jobResult->save();

            return $this->sendResponse('', 'Delivery completed successfully', '', $request->input('jrCompleteID'));
        } catch (\Throwable $th) {
            return $this->sendError('Error : ' . $th->getMessage(), 500);
        }
    }
}
