<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureList extends Model {

    use HasFactory;

    protected $table = "crc_product_feature_list";
    protected $fillable = [
        'user_id',
        'category',
        'product_id',
        'date',
        'amount',
        'card_id',
        'payment_status',
        'payment_raw',
        'payment_date',
        'status'
    ];

}
