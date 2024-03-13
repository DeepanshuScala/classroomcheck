<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'newsletters';
    protected $fillable = [
        'store_user_id',
        'store_url',
        'store_name',
        'email',
        'resource_grade',
        'resource_subject',
        'product_price_type',
        'product',
        'previous_listing',
    ];
}
