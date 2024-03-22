<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertPost extends Model
{
    use HasFactory;
    protected $table = 'expert_post';

    protected $primaryKey = 'ep_int_ref';

    protected $fillable = [
        'ep_var_user_ref',
        'ep_txt_desc',
        'ep_var_image',
        'ep_int_status'
    ];

    const CREATED_AT = 'ep_ts_created_at';
    const UPDATED_AT = 'ep_ts_updated_at';
}
