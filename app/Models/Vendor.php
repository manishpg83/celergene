<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasRoles, Notifiable;

    protected $guard = 'vendor';

    protected $fillable = [
        'name',
        'email',
        'password',
        'shop_name',
        'status',
        'created_by',
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
}
