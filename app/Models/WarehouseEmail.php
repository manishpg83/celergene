<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseEmail extends Model
{
    use HasFactory;

    protected $fillable = ['warehouse_id', 'email'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
