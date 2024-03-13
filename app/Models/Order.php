<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{OrderItem,User};

class Order extends Model {

    protected $table = 'crc_orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'total_quantity',
        'coupon_code',
        'coupon_type',
        'coupon_discount_amount',
        'buyer_tax',
        'status',
        'remark',
        'payment_type',
    ];

    public function orderProduct() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
