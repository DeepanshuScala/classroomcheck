<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    protected $table = 'countries';

    protected $fillable = [
        'sortname',
        'name',
        'slug',
        'phonecode',
        'status',
        'priority'
    ];
    public static $getCountriesValidation = [
    ];

}
