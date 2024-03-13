<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class FavouriteItem extends Model
{
    protected $table = 'crc_favourite_item';
    
    protected $fillable = [
        'user_id',
        'product_id'
    ];
    
    public static $validation = [
            'product_id'    =>  'required'
    ];
    
    public static $removeFavouriteItemValidation = [
            'favourite_id'      =>  '',
            'product_id'        =>  ''
    ];
    
    public static $getFavouriteItemsValidation = [
            'user_id'       =>  ''
    ];
    
    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    
    
    
    
    
    

}
