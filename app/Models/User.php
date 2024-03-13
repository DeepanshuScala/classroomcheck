<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\CartItem;
use App\Models\Store;
use App\Models\UserSettings;
use App\Models\Cartgiftcard;

//class User extends Authenticatable  implements MustVerifyEmail {
class User extends Authenticatable {

    use HasApiTokens,
        HasFactory,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'surname',
        'email',
        'role_id',
        'password',
        'address_line1',
        'address_line2',
        'city',
        'state_province_region',
        'postal_code',
        'country',
        'phone_country_code',
        'phone',
        'mob_phone_country_code',
        'mob_phone',
        'age',
        'image',
        'default_image',
        'tell_us_about_you',
        'detail_additional_information',
        'newsletter',
        'classroom_contributions',
        'terms_and_conditions',
        'password',
        'status',
        'is_deleted',
        'process_completion',
        'is_admin_relative',
        'verified',
        'grade_id',
        'interest_area',
        'stripe_customer_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static $authLoginValidation = [
        'email' => 'required|string|email',
        'password' => 'required|string'
    ];
    public static $authLoginCustomMessage = [
    ];
    public static $forgotPasswordValidation = [
        'email' => 'required|email|exists:users',
    ];
    public static $forgotPasswordCustomMessage = [
        'email.exists' => 'The input e-mail is invalid!',
    ];
    public static $updatePasswordValidation = [
        'email' => 'required|email|exists:users',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required'
    ];
    public static $updatePasswordCustomMessage = [
    ];
    public static $accountSignupValidation = [
        'first_name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        //'address_line1' => 'required|string|max:255',
        //'address_line2' => 'required|string|max:255',
        // 'city' => 'required|string|max:255',
        'state_province_region' => 'required|string|max:255',
//        'postal_code'           => 'required|numeric|lte:10',
        //'postal_code' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|max:10',
        'country' => 'required|string',
        //'phone_country_code' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|max:5',
        //'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|max:12',
        //'mob_phone_country_code' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|max:5',
        //'mob_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|max:12',
        'email' => 'required|string|email|unique:users|max:255',
        'password' => 'required|string|min:6|confirmed|max:255',
        'password_confirmation' => 'required|string',
//        'image'                 => 'required_without:default_image|mime:jpg,jpeg,gif,bmp,png,tif,tiff',
        'image' => 'required_without:default_image|mimes:jpg,png,jpeg,gif,tif,tiff|max:5127',
        //'tell_us_about_you' => 'required|max:500',
        //'detail_additional_information' => 'required|max:500',
        //'newsletter' => 'required',
        // 'classroom_contributions' => 'required',
        'terms_and_conditions' => 'required',
    ];
    public static $accountSignupCustomMessage = [
    ];
    public static $storeSignupValidation = [
        'first_name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        //'address_line1' => 'required|string|max:255',
        //'address_line2' => 'required|string|max:255',
        // 'city' => 'required|string|max:255',
        'state_province_region' => 'required|string|max:255',
//        'postal_code'           => 'required|numeric|lte:10',
        //'postal_code' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|max:10',
        'country' => 'required|string',
        //'phone_country_code' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|max:5',
        //'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|max:12',
        //'mob_phone_country_code' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|max:5',
        //'mob_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|max:12',
        'email' => 'required|string|email|unique:users|max:255',
        'password' => 'required|string|min:6|confirmed|max:255',
        'password_confirmation' => 'required|string',
//        'image'                 => 'required_without:default_image|mime:jpg,jpeg,gif,bmp,png,tif,tiff',
        'image' => 'required_without:default_image|mimes:jpg,png,jpeg,gif,tif,tiff|max:5127',
        //'default_image' => 'required_without:image|mimes:jpg,png,jpeg,gif,tif,tiff,bmp|max:5127',
        //'tell_us_about_you' => 'required|max:500',
        //'detail_additional_information' => 'required|max:500',
        //'newsletter' => 'required',
        // 'classroom_contributions' => 'required',
        'terms_and_conditions' => 'required',
    ];
    public static $storeSignupCustomMessage = [
    ];
    public static $changePasswordValidation = [
        'current_password' => 'required',
        'password' => 'required|string|min:6|confirmed',
//        'new_password'          => 'required|string|min:6',
//        'confirm_new_password'  => 'required|string|min:6',
    ];
    public static $changePasswordCustomMessage = [
    ];
    public static $profileImageUpdateValidation = [
        'profileImage' => 'required|image|mimes:jpg,png,jpeg,gif,tif,tiff|max:5127',
    ];
    public static $profileImageUpdateCustomMessage = [
    ];

    public function verifyUser() {
        return $this->hasOne('App\Models\VerifyUser');
    }

    public function cartsWithProductPrice() {
        return $this->hasMany(CartItem::class)
                        ->join('crc_products', 'crc_cart_items.product_id', 'crc_products.id')->where('crc_cart_items.type','product')
                        ->select('crc_cart_items.*', \DB::raw('crc_cart_items.quantity * crc_products.single_license as price'));
    }
    public function cartsWithgiftPrice() {
            return $this->hasMany(CartItem::class)
                            ->join('cartgiftcards', 'crc_cart_items.product_id', 'cartgiftcards.id')
                            ->select('crc_cart_items.*', \DB::raw('crc_cart_items.quantity * cartgiftcards.gift_amount as price'));
    }

    public function store() {
        return $this->hasOne(Store::class, 'user_id', 'id');
    }

    public function getUserSettings() {
        return $this->hasOne(UserSettings::class, 'user_id', 'id');
    }

}
