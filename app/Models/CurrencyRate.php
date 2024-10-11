<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'rate',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
