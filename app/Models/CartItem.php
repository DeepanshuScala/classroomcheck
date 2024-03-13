<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class CartItem extends Model
{
    protected $table = 'crc_cart_items';
    
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'type'
    ];
    
    public static $validation = [
            'product_id'    =>  'required',
//            'quantity'      =>  'required|integer|gt:0'
            'quantity'      =>  'integer|gt:0'
    ];
    
    public static $updateCartItemQuantityValidation = [
            'product_id'    =>  'required',
            'quantity'      =>  'required|integer|gt:0'
    ];
    
    public static $removeCartItemValidation = [
            'cart_id'    =>  ''
    ];
    
    public static $getCartItemsValidation = [
            'user_id'    =>  ''
    ];
    
    public static $removeAllCartItemsValidation = [
            'user_id'    =>  ''
    ];
    
    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    
    

}
