<?php

namespace App\Models\Revenue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $table = 'transaction_history';

    protected $primaryKey = 'th_int_ref';

    protected $fillable = [
        'th_up_var_ref',
        'th_jm_int_ref',
        'th_int_transaction_type',
        'th_int_payment_proof',
        'th_double_amount',
        'th_bank_name',
        'th_var_transfer_account_name',
        'th_int_transfer_account_num',
        'th_status'
    ];

    const CREATED_AT = 'th_ts_created_at';
    const UPDATED_AT = 'th_ts_updated_at';
}
