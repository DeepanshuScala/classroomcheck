<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {
    use HasFactory;
    
    protected $table = 'crc_product_images';
    
    protected $fillable = [
        'product_id',
        'user_id',
        'image'
    ];
    
    public static $validation = [
//            'product_id'    =>  '',
//            'image'         =>  'required'
    ];
    
    
    public static $ProductImageValidation = [
        'image' => 'mimes:jpg,png,jpeg,gif,tif,tiff,bmp|max:5127',
    ];
    
    public static $ProductImageValidationCustomMessage = [
    ];
}