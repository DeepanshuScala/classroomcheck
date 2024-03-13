<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Product,
    User
};

class RateReviews extends Model {

    use HasFactory;

    protected $table = 'crc_rate_review';
    protected $fillable = [
        'type',
        'order_id',
        'product_id',
        'seller_id',
        'user_id',
        'rating',
        'review'
    ];

    public function Product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    } 

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
