<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contributionstransactions extends Model
{
    use HasFactory;
    protected $table = 'contributionstransactions';

    protected $fillable = [
        'contribution_id',
        'txn_ref',
        'txn_raw',
        'amount',
        'status',
    ];
}
