<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model {

    use HasFactory;

    protected $table = "crc_stripe_account";
    protected $fillable = [
        'user_id',
        'account_id',
        'raw_data',
        'approved_status',
        'login_link'
    ];

}
