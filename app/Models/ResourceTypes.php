<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceTypes extends Model {

    use HasFactory;

    protected $table = 'crc_resource_types';
    protected $fillable = [
        'name',
        'status',
        'is_deleted'
    ];

}
