<?php

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'date_of_birth',
        'company',
        'email',
        'password',
        'type',
        'status',
        'profile_photo_path',
        'profile_photo_url',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'created_by',
        'is_guest',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
    ];

    /**
     * Check if the user has the admin role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if the user has the vendor role.
     *
     * @return bool
     */
    public function isVendor(): bool
    {
        return $this->hasRole('vendor');
    }

    /**
     * Check if the user has the customer role.
     *
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}
