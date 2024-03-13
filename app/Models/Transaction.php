<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'crc_transactions';
    protected $fillable = [
        'user_id',
        'order_id',
        'txn_ref',
        'txn_raw',
        'amount',
        'status',
        'card_id',
        'payment_type'
    ];
    
    public static $orderDetailsValidation = [
            'user_id'           => '',
            'order_id'          => 'required'
    ];

    

    

    
    
    
    
}
