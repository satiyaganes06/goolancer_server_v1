<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertPostLink extends Model
{
    use HasFactory;

    protected $table = 'expert_post_link';

    protected $primaryKey = 'epl_int_ref';

    protected $fillable = [
        'epl_int_es_ref',
        'epl_int_ep_ref'
    ];

    const CREATED_AT = 'epl_ts_created_at';
    const UPDATED_AT = 'epl_ts_updated_at';
}
