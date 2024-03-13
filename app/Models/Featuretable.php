<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Featuretable extends Model
{
    protected $table = 'featuretable';
    
    protected $fillable = [
        'basic_membership',
        'premium_membership',
        'all_seller_membership',
        'basic_payout',
        'premium_payout',
        'allseller_payout',
        'basic_transaction',
        'premium_transaction',
        'allseller_transaction',
        'basic_max',
        'premium_max',
        'allseller_max',
        'basic_file',
        'premium_file',
        'allseller_file',
        'basic_video',
        'premium_video',
        'allseller_video',
    ];
}