<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model {

    use HasFactory;

    protected $table = "crc_faq";
    protected $fillable = [
        'question',
        'answer',
        'has_table',
        'tableid',
        'status',
        'order',
        'is_deleted'
    ];

}
