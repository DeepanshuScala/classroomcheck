<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller_Social_Media extends Model
{
    use HasFactory;
    protected $table = "seller__social__media";
    protected $fillable = [
        'storeurl',
        'store_name',
        'email',
        'user_id',
        'store_fb_url',
        'store_insta_url',
        'submission_type',
        'submission_type_details',
        'resource_grade',
        'resource_subject',
        'explain_submission',
        'media',
    ];
     public static $storeSignupValidation = [
        'storeurl' => 'required|string|max:255',
        'store_name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'submission_type' => 'required|string|max:255',
        'submission_type_details' => 'required|string|max:255',
        'resource_grade' => 'required|string|max:255',
        'resource_subject' => 'required|string|max:255',
        'explain_submission' => 'required|string|max:255',
        'media' => 'mimes:mp4,jpg,png,jpeg,gif,tif,tiff,bmp|max:51270',

    ];
    public static $accountSignupCustomMessage = [
    ];
}
