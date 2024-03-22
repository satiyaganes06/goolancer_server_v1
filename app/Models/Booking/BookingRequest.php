<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    use HasFactory;

    protected $table = 'booking_request';

    protected $primaryKey = 'br_int_ref';

    protected $fillable = [
        'br_var_up_ref',
        'br_int_es_ref',
        'br_var_title',
        'br_txt_desc',
        'br_var_address',
        'br_int_zip_code',
        'br_var_state',
        'br_double_price',
        'br_var_delivery_time',
        'br_int_status',
    ];

    const CREATED_AT = 'br_ts_created_at';
    const UPDATED_AT = 'br_ts_updated_at';
}
