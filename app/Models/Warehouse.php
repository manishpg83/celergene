<?php

namespace App\Models;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'warehouse_name',
        'country',
        'address',
        'email',
        'phone',
        'type',
        'remarks',
        'created_by',
        'modified_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'warehouse_id');
    }
    
    public function emails()
    {
        return $this->hasMany(WarehouseEmail::class);
    }

}
