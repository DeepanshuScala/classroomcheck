<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temporaryimages extends Model
{
    use HasFactory;
    protected $table = 'temporaryimages';
    protected $fillable = [
        'user_id',
        'product_id',
        'image',
        'type'
    ];
}