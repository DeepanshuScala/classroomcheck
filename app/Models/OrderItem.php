<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Product,Cartgiftcard,User,Order};

class OrderItem extends Model
{
    protected $table = 'crc_order_items';
    
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'quantity',
        'price',
        'amount',
        'commission',
        'transaction_charges',
        'sales_tax',
        'attributes',
        'payment_type',
        'status',
        'payout_status',
        'type',
        'downloads_left',
        'purchasedon'
    ];
    
    
    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function giftcard() {
        return $this->hasOne(Cartgiftcard::class, 'id', 'product_id');
    }

    
    
    
    
}
