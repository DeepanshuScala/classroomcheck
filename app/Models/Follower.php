<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model {

    use HasFactory;

    protected $table = "crc_follower";
    protected $fillable = [
        'followed_to',
        'followed_by',
    ];

    public function sellerDetails() {
        return $this->hasOne('App\Models\User', 'id', 'followed_to')->with(['store']);
    }

}
