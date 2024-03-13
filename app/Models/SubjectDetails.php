<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GradeLevels;

class SubjectDetails extends Model {

    use HasFactory;

    protected $table = 'crc_subject_details';
    protected $fillable = [
        'parent_id',
        'grade_id',
        'name',
        'status',
        'is_deleted'
    ];

    public function gradeLevel() {
        return $this->hasOne(GradeLevels::class, 'id', 'grade_id');
    }

}
