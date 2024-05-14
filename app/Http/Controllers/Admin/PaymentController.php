<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Certificate\ExpertCertificate;
use App\Models\Job\JobPayment;
use App\Models\Job\JobMain;
use App\Models\Revenue\ExpertRevenueAccount;
use App\Models\Revenue\RefundRequest;
use App\Models\Service\ExpertService;
use App\Models\Revenue\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User\UserProfile;

class PaymentController extends BaseController
{


    public function PaymentApproval()
    {
        $payments = JobPayment::join('user_profile', 'job_payment.jp_var_up_ref', '=', 'user_profile.up_int_ref')
            ->join('job_main', 'job_payment.jp_jm_ref', '=', 'job_main.jm_int_ref')
            ->join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
            ->select('job_payment.*', 'user_profile.*', 'booking_request.*')
            ->orderByRaw('jp_int_status = 0 DESC')->paginate(10);
        return view('admin.approval.payment_approval', compact('payments'));
    }

    public function approvePayment($id, $status, $paymentType)
    {
        /**  FIX ME!!! Its not add/remove from the expert_revenue_account  */

        $payment = JobPayment::find($id);
        $payment->jp_int_status = $status;
        $payment->save();

        if ($status == 1) {

            if ($paymentType == 0) {
                $jobMain = JobMain::where('jm_int_ref', $payment->jp_jm_ref)->update(
                    array(
                        'jm_int_timeline_status' => 1
                    )
                );
                

                $userIDs = JobMain::join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
                ->join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
                ->select('booking_request.br_var_up_ref as clientID', 'expert_service.es_var_user_ref as expertID')->where('jm_int_ref', $payment->jp_jm_ref)->first();

                //Remove trans table and add era table and add the amount in quen
                $revenue = ExpertRevenueAccount::where('era_up_var_ref', $userIDs->expertID)->first();
                $revenue->era_double_deposit_queue = $revenue->era_double_deposit_queue + $payment->jp_double_account_transfer_amount;
                $revenue->save();

                $transactionHistory = TransactionHistory::create(
                    array(
                        'th_up_var_ref' => $payment->jp_var_up_ref,
                        'th_jm_int_ref' => $payment->jp_jm_ref,
                        'th_int_transaction_type' => 0,
                        'th_double_amount' => $payment->jp_double_account_transfer_amount,
                        'th_bank_name' => '',
                        'th_int_payment_proof' => $payment->jp_var_receipt,
                        'th_var_transfer_account_name' => $payment->jp_var_acount_transfer_name,
                        'th_status' => 1
                    )
                );

                $transactionHistory->save();
            } elseif ($paymentType == 1) {
                $jobMain = JobMain::where('jm_int_ref', $payment->jp_jm_ref)->update(
                    array(
                        'jm_int_timeline_status' => 3
                    )
                );

                $transactionHistory = TransactionHistory::create(
                    array(
                        'th_up_var_ref' => $payment->jp_var_up_ref,
                        'th_jm_int_ref' => $payment->jp_jm_ref,
                        'th_int_transaction_type' => 0,
                        'th_double_amount' => $payment->jp_double_account_transfer_amount,
                        'th_bank_name' => '',
                        'th_int_payment_proof' => $payment->jp_var_receipt,
                        'th_var_transfer_account_name' => $payment->jp_var_acount_transfer_name,
                        'th_status' => 1
                    )
                );
                $transactionHistory->save();
            }
        }

        $payments = JobPayment::join('user_profile', 'job_payment.jp_var_up_ref', '=', 'user_profile.up_int_ref')
            ->join('job_main', 'job_payment.jp_jm_ref', '=', 'job_main.jm_int_ref')
            ->join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
            ->select('job_payment.*', 'user_profile.*', 'booking_request.*')
            ->orderByRaw('jp_int_status = 0 DESC')->paginate(10);

        return redirect()->route('admin.approval.payment_approval', compact('payments'));
    }


    public function viewAllRefundList()
    {

        $refundDetails = RefundRequest::orderBy('rr_int_status', 'asc')->paginate(5);

        return view('admin.approval.refund_approval', compact('refundDetails'));
    }

    public function ViewRefundInfo($id)
    {
        $refundDetail = RefundRequest::where('rr_int_ref', $id)->first();
        return view('admin.approval.view_refund', compact('refundDetail'));
    }

    public function approveRefund(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $refund = RefundRequest::find($id);
            $refund->rr_int_status = $request->input('status');
            $refund->save();


            $userIDs =  RefundRequest::join('job_main', 'refund_request.rr_jm_ref', '=', 'job_main.jm_int_ref')
                ->join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
                ->join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
                ->select('booking_request.br_var_up_ref as clientID', 'expert_service.es_var_user_ref as expertID', 'booking_request.br_double_price as jobPrice')->where('rr_int_ref', $id)->first();

            //Accept refund
            if ($request->input('status') == 1) {

                // Minus the era_double_deposit_queue in expert_revenue_account table
                $revenue = ExpertRevenueAccount::where('era_up_var_ref', $userIDs->expertID)->first();
                $revenue->era_double_deposit_queue = $revenue->era_double_deposit_queue - $refund->rr_double_amount;
                $revenue->save();

                //FIX ME: Add the transaction history
                $file = $request->file('receipt');
                $filePath = $file->store('uploads/files/PaymentReceipt'); //Fix in online mode

                $transactionHistory = new TransactionHistory();
                $transactionHistory->th_up_var_ref = $userIDs->clientID;
                $transactionHistory->th_jm_int_ref = $refund->rr_jm_ref;
                $transactionHistory->th_int_transaction_type = 2;
                $transactionHistory->th_double_amount =  $refund->rr_double_amount;
                $transactionHistory->th_bank_name = 'Maybank';
                $transactionHistory->th_int_payment_proof = $filePath;
                $transactionHistory->th_var_transfer_account_name =  'Goolancer';
                $transactionHistory->th_status =  1;
                $transactionHistory->save();


                //Reject refund
            } else if ($request->input('status') == 2) {


                $transactionHistoryClient = new TransactionHistory();
                $transactionHistoryClient->th_up_var_ref = $userIDs->clientID;
                $transactionHistoryClient->th_jm_int_ref = $refund->rr_jm_ref;
                $transactionHistoryClient->th_int_transaction_type = 3;
                $transactionHistoryClient->th_bank_name = $refund->rr_double_amount;
                $transactionHistoryClient->th_double_amount =  $userIDs->jobPrice * $request->input('penaltyPercentage');
                $transactionHistoryClient->th_status =  0;
                $transactionHistoryClient->save();
        
            }

            DB::commit();


            $refundDetails = RefundRequest::orderBy('rr_int_status', 'asc')->paginate(5);

            return redirect()->route('admin.viewAllRefundsInfo', compact('refundDetails'));
        } catch (\Throwable $th) {

            DB::rollBack();
            dd($th);
        }
    }

    public function viewAllTransactionInfo()
    {
        $transactionDetails = TransactionHistory::orderBy('th_status', 'asc')->paginate(5);

        for ($i = 0; $i < count($transactionDetails); $i++) {
            $transactionDetails[$i]->userProfile = UserProfile::where('up_int_ref', $transactionDetails[$i]->th_up_var_ref)->first();
            $transactionDetails[$i]->jobMain = JobMain::where('jm_int_ref', $transactionDetails[$i]->th_jm_int_ref)->first();
        }
        return view('admin.approval.transaction_history_approval', compact('transactionDetails'));
    }

    public function ViewTransactionInfo($id)
    {
        $transactionDetail = TransactionHistory::where('th_int_ref', $id)->first();
        $transactionDetail->userProfile = UserProfile::where('up_int_ref', $transactionDetail->th_up_var_ref)->first();
        return view('admin.approval.view_transaction_history', compact('transactionDetail'));
    }

    public function transactionApproval(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $transaction = TransactionHistory::find($id);
            $transaction->th_status = $request->input('status');
            $transaction->save();

            if ($request->input('status') == 1) {
                if ($transaction->th_int_transaction_type == 1) {
                    //Widthdraw
                    //FIX ME: Add the transaction history
                    $file = $request->file('receipt');
                    $filePath = $file->store('uploads/files/PaymentReceipt'); //Fix in online mode
                    $transaction->th_int_payment_proof = $filePath;
                    $transaction->save();

                    //Minus the era_double_total_balance in expert_revenue_account table
                    $revenue = ExpertRevenueAccount::where('era_up_var_ref', $transaction->th_up_var_ref)->first();
                    $revenue->era_double_total_balance = $revenue->era_double_total_balance - $transaction->th_double_amount;
                    $revenue->save();
                }  else if ($transaction->th_int_transaction_type == 3) {
                    //Penalty
                    $expertID = JobMain::join('booking_request', 'job_main.jm_br_ref', '=', 'booking_request.br_int_ref')
                        ->join('expert_service', 'booking_request.br_int_es_ref', '=', 'expert_service.es_int_ref')
                        ->select('expert_service.es_var_user_ref as expertID')->where('job_main.jm_int_ref', $transaction->th_jm_int_ref)->first();

                    // Minus the era_double_deposit_queue in expert_revenue_account table and add the amount in era_double_dopsit_amount
                    $revenue = ExpertRevenueAccount::where('era_up_var_ref', $expertID->expertID)->first();
                    $revenue->era_double_deposit_queue = $revenue->era_double_deposit_queue - $transaction->th_bank_name;
                    $revenue->era_double_total_balance = $revenue->era_double_total_balance + $transaction->th_double_amount + $transaction->th_bank_name;
                    $revenue->save();


                    $transactionHistoryExpert = new TransactionHistory;
                    $transactionHistoryExpert->th_up_var_ref = $expertID->expertID;
                    $transactionHistoryExpert->th_jm_int_ref = $transaction->th_jm_int_ref;
                    $transactionHistoryExpert->th_int_transaction_type = 0;
                    $transactionHistoryExpert->th_double_amount = $transaction->th_double_amount;
                    $transactionHistoryExpert->th_status =  1;
                    $transactionHistoryExpert->save();
                }
            }

            DB::commit();

            $transactionDetails = TransactionHistory::orderBy('th_status', 'asc')->paginate(5);
            return redirect()->route('admin.viewAllTransactionInfo', compact('transactionDetails'));
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }
}
