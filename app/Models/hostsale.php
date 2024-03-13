<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hostsale extends Model
{
    use HasFactory;

    protected $table = 'hostsales';
    protected $fillable = [
        'start_date',
        'end_date',
        'discount',
        'products',
        'is_deleted',
        'user_id'
    ];
}
