<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoDetails extends Model {

    use HasFactory;

    protected $table = 'crc_promo_deatails';
    protected $fillable = [
        'type',
        'promo_usage_for',
        'user_id',
        'title',
        'description',
        'promo_code',
        'start_at',
        'end_at',
        'discount_in',
        'amount',
        'status'
    ];

}
