<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model {

    use HasFactory;

    protected $table = 'user_card';
    protected $fillable = [
        'user_id',
        'stripe_card_id',
        'card_holder_name',
        'card_number',
        'exp_month',
        'exp_year',
        'cvc',
        'card_type',
        'stripe_token',
        'is_deleted',
        'is_default_card',
        'brand'
    ];

}
