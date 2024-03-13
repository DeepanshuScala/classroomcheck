<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model {

    use HasFactory;

    protected $table = 'crc_about_us';
    protected $fillable = [
        'about_us',
        'about_us_image',
        'our_vision',
        'our_mission',
        'founding_story_description',
        'founding_story_image'
    ];

}
