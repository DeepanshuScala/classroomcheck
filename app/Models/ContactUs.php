<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model {

    use HasFactory;

    protected $table = "crc_contact_us";
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'message',
        'topic',
        'status'
    ];

}
