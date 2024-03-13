<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model {

    use HasFactory;

    protected $table = "crc_store";
    protected $fillable = [
        'user_id',
        'store_name',
        'store_logo',
        'store_banner',
        'store_status',
        'default_store_logo',
        'default_store_banner',
        'sale_commission',
        'transactioncharge_aus',
        'transactioncharge_other',
        'salestax',
    ];
     public static $accountSignupValidation = [
    
        'store_logo' => 'mimes:jpg,png,jpeg,gif,tif,tiff|max:5127',
        'store_banner' => 'mimes:jpg,png,jpeg,gif,tif,tiff|max:5127',
    ];
    public static $accountSignupCustomMessage = [
    ];
}
