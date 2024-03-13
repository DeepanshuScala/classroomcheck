<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model {

//    protected $table = 'states';

    protected $fillable = [
        'name',
        'country_id',
        'status'
    ];
    public static $getstatesByCountryValidation = [
        'country_id' => 'required',
        'state_name' => ''
    ];

}
