<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_type_id',
        'user_id',
        'salutation',
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'image',
        'company_name',
        'business_reg_number',
        'vat_number',
        'payment_term_display',
        'payment_term_actual',
        'credit_rating',
        'allow_consignment',
        'must_receive_payment_before_delivery',
        'billing_address',
        'billing_fname',
        'billing_lname',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_phone',
        'billing_email',
        'billing_country',
        'billing_postal_code',
        'shipping_address_receiver_name_1',
        'shipping_address_receiver_lname_1',
        'shipping_address_1',
        'shipping_address_1_1',
        'shipping_city_1',
        'shipping_state_1',
        'shipping_phone_1',
        'shipping_email_1',
        'shipping_company_name_1', 
        'shipping_country_1',
        'shipping_postal_code_1',
        'shipping_address_receiver_name_2',
        'shipping_address_receiver_lname_2', 
        'shipping_address_2',
        'shipping_address_2_1',  
        'shipping_city_2', 
        'shipping_state_2',
        'shipping_phone_2', 
        'shipping_email_2',
        'shipping_company_name_2', 
        'shipping_address_2',
        'shipping_country_2',
        'shipping_postal_code_2',
        'shipping_address_receiver_name_3',
        'shipping_address_receiver_lname_3', 
        'shipping_address_3',
        'shipping_address_3_1',  
        'shipping_city_3',  
        'shipping_state_3',  
        'shipping_phone_3', 
        'shipping_email_3',
        'shipping_company_name_3', 
        'shipping_address_3',
        'shipping_country_3',
        'shipping_postal_code_3',
        'created_by',
        'updated_by',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('admin/assets/img/profile_img/' . $this->image);
        }
        return asset('images/default-avatar.png');
    }

    public function customerType()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id');
    }
    public function orders()
    {
        return $this->hasMany(OrderMaster::class, 'customer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
