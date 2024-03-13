<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sellersemaillog extends Model
{
    use HasFactory;
    protected $table = "sellersemaillogs";
    protected $fillable = [
        'store_user_id',
        'subject',
        'description',
    ];
}
