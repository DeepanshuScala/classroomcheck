<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoUsed extends Model
{
    use HasFactory;
    protected $table = 'promo_used';
    protected $fillable = [
        'user_id',
        'promocodeid',
    ];
}
