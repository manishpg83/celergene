<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_type_id', // Use this field now
        'salutation',
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'company_name',
        'business_reg_number',
        'vat_number',
        'payment_term_display',
        'payment_term_actual',
        'credit_rating',
        'allow_consignment',
        'must_receive_payment_before_delivery',
        'billing_address',
        'billing_country',
        'billing_postal_code',
        'shipping_address_receiver_name_1',
        'shipping_address_1',
        'shipping_country_1',
        'shipping_postal_code_1',
        'shipping_address_receiver_name_2',
        'shipping_address_2',
        'shipping_country_2',
        'shipping_postal_code_2',
        'shipping_address_receiver_name_3',
        'shipping_address_3',
        'shipping_country_3',
        'shipping_postal_code_3',
        'created_by',
        'updated_by',
    ];

    // Define the relationship with CustomerType
    public function customerType()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id');
    }
}

