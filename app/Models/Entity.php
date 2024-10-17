<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'company_name',
        'address',
        'country',
        'postal_code',
        'business_reg_number',
        'vat_number',
        'bank_account_name',
        'bank_account_number',
        'currency',
        'bank_name',
        'bank_address',
        'bank_swift_code',
        'bank_iban_number',
        'bank_code',
        'bank_branch_code',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that created the entity.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include active entities.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive entities.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}
