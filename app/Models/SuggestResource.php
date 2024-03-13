<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{GradeLevels ,SubjectDetails ,ResourceTypes};

class SuggestResource extends Model {

    use HasFactory;

    protected $table = 'crc_suggest_resource';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'grade_id',
        'subject_id',
        'resource_id',
        'description',
        'other_description',
        'is_sent_to_seller',
        'sent_date',
        'seller_ids'
    ];

    public function gradeLevel() {
        return $this->hasOne(GradeLevels::class, 'id', 'grade_id');
    }

    public function subject() {
        return $this->hasOne(SubjectDetails::class, 'id', 'subject_id');
    } 

    public function resource() {
        return $this->hasOne(ResourceTypes::class, 'id', 'resource_id');
    }

}