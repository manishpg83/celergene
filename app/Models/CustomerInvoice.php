<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'invoice_date',
        'amount',
        'file_path',
        'original_filename',
        'notes'
    ];
    
    protected $casts = [
        'invoice_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $dates = ['invoice_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}