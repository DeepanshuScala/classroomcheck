<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Order};

class GiftCards extends Model {

    use HasFactory;

    protected $table = 'crc_gift_cards';
    protected $fillable = [
        'sender_user_id',
        'from_name',
        'recipient_user_id',
        'recipient_email',
        'gift_code',
        'gift_amount',
        'message',
        'sender_card_id',
        'remaining_amount',
        'is_gift_card_used',
        'order_id',
        'txn_raw'
    ];
    public function orders() {
        return $this->hasMany(Order::class, 'coupon_code', 'gift_code');
    }

}
