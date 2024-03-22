<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertCertificate extends Model
{
    use HasFactory;

    protected $table = 'expert_certificate';

    protected $primaryKey = 'ec_int_ref';

    protected $fillable = [
        'ec_var_user_ref',
        'ec_var_registration_no',
        'ec_var_title',
        'ec_var_description',
        'ec_date_issue_date',
        'ec_date_expiry_date',
        'ec_var_image',
        'ec_int_status'
    ];

    const CREATED_AT = 'ec_ts_created_at';
    const UPDATED_AT = 'ec_ts_updated_at';
}
