<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertService extends Model
{
    use HasFactory;

    protected $table = 'expert_service';

    protected $primaryKey = 'es_int_ref';

    protected $fillable = [
        'es_var_user_ref',
        'es_int_service_type_ref',
        'es_var_images',
        'es_var_title',
        'es_txt_description',
        'es_var_starting_price',
        'es_estimate_delivery_time',
        'es_bool_isInHouseExpert',
        'es_int_status'
    ];

    const CREATED_AT = 'es_ts_created_at';
    const UPDATED_AT = 'es_ts_updated_at';
}
