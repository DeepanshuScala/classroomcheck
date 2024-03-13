<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model {

    use HasFactory;

    protected $table = 'crc_blogs';
    protected $fillable = [
        'title',
        'short_description',
        'long_description',
        'image1',
        'image2',
        'image3',
        'status'
    ];

}
