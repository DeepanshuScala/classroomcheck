<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\{GradeLevels , Product ,ResourceTypes,User};

class crc_report_issue extends Model
{
    use HasFactory;
    protected $table = 'crc_report_issues';
    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'subject',
        'issue',
        'status'
    ];

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    } 

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
