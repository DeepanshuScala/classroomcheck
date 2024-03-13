<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartgiftcard extends Model
{
    use HasFactory;
    protected $table = 'cartgiftcards';
     protected $fillable = [
        'from_name',
        'recipient_user_id',
        'recipient_email',
        'gift_amount',
        'message',
        'recipient_role'
    ];
}
