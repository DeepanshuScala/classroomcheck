<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOffer extends Model {

    protected $table = 'seller_offer';

    protected $fillable = [
        'code',
        'is_active',
        'banner',
    ];
}