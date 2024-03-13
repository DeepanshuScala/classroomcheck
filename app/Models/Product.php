<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    ProductImage,
    SubjectDetails,
    Country,
    ResourceTypes,
    Languages,
    GradeLevels,
    OrderItem,
    User
};

class Product extends Model {

    use HasFactory;

    protected $table = 'crc_products';
    protected $fillable = [
        'user_id',
        'store_id',
        'product_type',
        'language',
        'resource_type',
        'product_title',
        'main_image',
        'product_file',
        'description',
        'year_level',
        'subject_area',
        'subject_sub_area',
        'custom_category',
        'outcome_country',
        'standard_outcome',
        'answer_key',
        'teaching_duration',
        'is_paid_or_free',
        'single_license',
        'type',
        'bundleproducts',
        'multiple_license',
        'terms_and_conditions',
        'tax_code',
        'no_of_pages_slides',
        'is_deleted',
    ];
    public static $addProductValidation = [
        'user_id' => '',
        'product_type' => 'required|string',
        'product_title' => 'required|string',
        'description' => 'required|string|max:1000',
        'year_level' => 'required',
        'subject_area' => 'required',
        'teaching_duration' => 'required|string',
        'no_of_pages_slides' => '',
        'main_image' => 'mimes:jpg,png,jpeg,gif,tif,tiff,bmp|max:5127',
        
//        'product_file'          => 'required|mimes:doc, docx, xls, xlsx, ppt, pptx,txt, rtf, ps, eps, prn, bmp, jpeg, gif, tiff, png, pcx, rle, dib,html, wpd, odt, odp, ods, pdf, odg, odf, sxw, sxi, sxc, sxd, stw, psd, ai, indd, u3d, prc, dwg, dwt, dxf, dwf, dst, xps, mpp, vsd',
        'product_file' => 'required|max:51270',
    ];
    public static $updateProductValidation = [
        'user_id' => '',
        'product_type' => 'required|string',
        'product_title' => 'required|string',
        'description' => 'required|string|max:1000',
        'year_level' => 'required',
        'subject_area' => 'required',
        'teaching_duration' => 'required|string',
        'no_of_pages_slides' => '',
        'main_image' => 'mimes:jpg,png,jpeg,gif,tif,tiff,bmp|max:5127',
    ];
    public static $addProductCustomMessage = [
    ];

    public function productImages() {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function productSubjectArea() {
        return $this->hasOne(SubjectDetails::class, 'id', 'subject_area');
    }

    public function searchproductSubjectSubArea() {
        return $this->hasOne(SubjectDetails::class, 'id', 'subject_sub_area');
    }

    public function searchproductSubjectSubSubArea() {
        return $this->hasOne(SubjectDetails::class, 'id', 'subject_sub_sub_area');
    }

    public function productSubjectSubArea() {
        return $this->hasOne(SubjectDetails::class, 'parent_id', 'subject_area');
    } 

    public function productResourceType() {
        return $this->hasOne(ResourceTypes::class, 'id', 'resource_type');
    } 

    public function productlanguage() {
        return $this->hasOne(Languages::class, 'id', 'language');
    }

    public function productuser(){
        return $this->hasOne(User::class, 'id', 'user_id')->where('user.status',1);
    }

    public function productstore(){
        return $this->hasOne(Store::class, 'user_id', 'user_id');
    }

    public function productGradelevel() {
        
        // $foreignKey = 'id';
        // $instance = new GradeLevels();
        // $localKey = 'year_level';

        //return new HasManyJson($grde->newQuery(), $this, $foreignKey, $instance->getTable().'.'.$localKey);
        return $this->hasMany(GradeLevels::class, 'id', 'year_level');
    } 


    public function productOutcomeCountry() {
        return $this->hasOne(Country::class, 'id', 'outcome_country');
    }
    
    public function ratings(){
        return $this->hasMany('App\Models\RateReviews');
    }

    public function orders(){
        return $this->hasMany('App\Models\OrderItem');
    }

    public function FeatureList()
    {
        return $this->hasMany('App\Models\FeatureList');
    }
}
