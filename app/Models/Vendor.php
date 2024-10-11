<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasRoles, Notifiable, SoftDeletes;

    protected $guard = 'vendor';

    protected $fillable = [
        'name',
        'email',
        'password',
        'shop_name',
        'status',
        'created_by',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function isVendor()
    {
        return true; // Adjust this logic based on your application's requirements
    }
}
