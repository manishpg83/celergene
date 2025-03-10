<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'batchnumbers'; // Explicitly define the table name

    protected $fillable = [
        'batch_number',
        'status',
    ];
}