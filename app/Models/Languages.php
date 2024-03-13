<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model {

    use HasFactory;

    protected $table = "crc_languages";
    protected $fillable = [
        'language',
        'status'
    ];

}
