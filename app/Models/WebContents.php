<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebContents extends Model {

    use HasFactory;

    protected $table = 'crc_web_content';
    protected $fillable = [
        'parent_page',
        'web_page',
        'slug',
        'description',
        'url_link'
    ];

}
