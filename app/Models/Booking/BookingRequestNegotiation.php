<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRequestNegotiation extends Model
{
    use HasFactory;

    protected $table = 'booking_request_negotiation';

    protected $primaryKey = 'brn_int_ref';

    protected $fillable = [
        'brn_br_int_ref',
        'brn_int_user_type',
        'brn_txt_desc',
        'brn_requested_price',
        'brn_date_deadline',
        'brn_int_status'
    ];

    const CREATED_AT = 'brn_ts_created_at';
    const UPDATED_AT = 'brn_ts_updated_at';
}
