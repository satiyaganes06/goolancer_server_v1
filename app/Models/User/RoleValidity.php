<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class RoleValidity extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'role_validity';

    protected $primaryKey = 'rv_int_ref';

    protected $fillable = [
        'rv_int_rolelogin_ref',
        'rv_date_valid_until',
        'rv_int_status',
        'rv_int_billing_ref'
    ];

    const CREATED_AT = 'rv_ts_created_at';
    const UPDATED_AT = 'rv_ts_updated_at';
}
