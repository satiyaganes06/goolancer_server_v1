<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController as BaseController;
use App\Models\Certificate\ExpertCertificate;
use App\Models\Job\JobPayment;
use App\Models\Job\JobMain;
use App\Models\Service\ExpertService;
use App\Models\Revenue\TransactionHistory;

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
        $payment = JobPayment::find($id);
        $payment->jp_int_status = $status;
        $payment->save();

        if($status == 1){

            if($paymentType == 0){
                $jobMain = JobMain::where('jm_int_ref', $payment->jp_jm_ref)->update(
                    array(
                        'jm_int_timeline_status' => 1
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

            }elseif($paymentType == 1){
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

}
