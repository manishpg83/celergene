<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_name',
        'country',
        'remarks',
        'created_by',
        'created_date',
        'modified_date',
    ];

    protected $dates = [
        'created_date',
        'modified_date',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        // Set created_date when creating a record
        static::creating(function ($supplier) {
            $supplier->created_date = now();
            $supplier->created_by = Auth::id(); // Update modified_by automatically
        });

        // Update modified_date when updating a record
        static::updating(function ($supplier) {
            $supplier->modified_date = now();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
