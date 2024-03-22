<?php

namespace App\Models\Certificate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertCertificateLink extends Model
{
    use HasFactory;

    protected $table = 'expert_cert_link';

    protected $primaryKey = 'ecl_int_ref';

    protected $fillable = [
        'ecl_int_es_ref',
        'ecl_int_ec_ref'
    ];

    const CREATED_AT = 'ecl_ts_created_at';
    const UPDATED_AT = 'ecl_ts_updated_at';
}
