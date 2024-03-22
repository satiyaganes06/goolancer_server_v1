<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRequestImage extends Model
{
    use HasFactory;

    protected $table = 'booking_request_image';

    protected $primaryKey = 'bri_int_ref';

    protected $fillable = [
        'bri_br_ref',
        'bri_booking_image'
    ];

    const CREATED_AT = 'bri_ts_created_at';
    const UPDATED_AT = 'bri_ts_updated_at';
}
