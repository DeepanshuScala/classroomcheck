<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOfferApplied extends Model {

    protected $table = 'Sellerofferapplied';

    protected $fillable = [
        'userid',
        'created_at',
        'updated_at',
    ];
}