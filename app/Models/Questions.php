<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;
    protected $fillable = [
    	'parent_id',
        'sender_id',
        'receiver_id',
        'product_id',
        'question',
        'type'
    ];
}
