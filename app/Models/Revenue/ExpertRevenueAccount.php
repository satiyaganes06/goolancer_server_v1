<?php

namespace App\Models\Revenue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertRevenueAccount extends Model
{
    use HasFactory;

    protected $table = 'expert_revenue_account';

    protected $primaryKey = 'era_int_ref';

    protected $fillable = [
        'era_up_var_ref',
        'era_double_total_balance',
        'era_double_total_withdrawn'
    ];

    const CREATED_AT = 'era_ts_created_at';
    const UPDATED_AT = 'era_ts_updated_at';
}
