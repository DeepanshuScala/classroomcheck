<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model {

    use HasFactory;

    protected $table = "crc_contribution";
    protected $fillable = [
        'user_id',
        'user_name',
        'first_name',
        'surname',
        'fundraising_title',
        'fundraising_slogan',
        'fundraising_banner',
        'about_fundraiser',
        'target_amount',
        'funded_amount',
        'exp_date'
    ];
    public static $classroomContributionValidation = [
        'fundraising_banner' => 'mimes:jpg,png,jpeg,gif,tif,tiff,bmp|max:5127',
    ];
    public static $classroomContributionCustomMessage = [
        'fundraising_banner.max' => 'The fundraising banner must not exceed 5mb.'
    ];
}
