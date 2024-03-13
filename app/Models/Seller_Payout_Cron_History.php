<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller_Payout_Cron_History extends Model
{
    use HasFactory;
    protected $table = "seller_payout_cron_history";
    protected $fillable = [
        'seller_user_id',
        'payout_amount',
        'commission',
        'transaction_charges',
        'sales_tax',
        'payout_selling_history_id',
        'payout_status',
    ];
}
