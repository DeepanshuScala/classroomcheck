<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevels extends Model {

    use HasFactory;

    protected $table = 'crc_grade_levels';
    protected $fillable = [
        'grade',
        'status'
    ];

}
