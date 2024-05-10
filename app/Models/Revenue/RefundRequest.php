<?php

namespace App\Models\Revenue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    use HasFactory;

    protected $table = 'refund_request';

    protected $primaryKey = 'rr_int_ref';

    protected $fillable = [
        'rr_jm_ref',
        'rr_var_reason',
        'rr_double_amount',
        'rr_int_status',
        'rr_var_admin_remark'
    ];

    const CREATED_AT = 'rr_ts_created_at';
    const UPDATED_AT = 'rr_ts_updated_at';
}
