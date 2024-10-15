<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'nactive'])->default('Active');
            $table->enum('customer_type', ['Corporate', 'Individual']);
            $table->string('salutation')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_number');
            $table->string('email');
            $table->string('company_name')->nullable();
            $table->string('business_reg_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('payment_term_display');
            $table->enum('payment_term_actual', ['7D', '14D', '30D'])->comment('For AR aging flagging for debtors list');
            $table->string('credit_rating');
            $table->boolean('allow_consignment');
            $table->boolean('must_receive_payment_before_delivery');
            $table->string('billing_address');
            $table->string('billing_country');
            $table->string('billing_postal_code');
            $table->string('shipping_address_receiver_name_1');
            $table->string('shipping_address_1');
            $table->string('shipping_country_1');
            $table->string('shipping_postal_code_1');
            $table->string('shipping_address_receiver_name_2')->nullable();
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_country_2')->nullable();
            $table->string('shipping_postal_code_2')->nullable();
            $table->string('shipping_address_receiver_name_3')->nullable();
            $table->string('shipping_address_3')->nullable();
            $table->string('shipping_country_3')->nullable();
            $table->string('shipping_postal_code_3')->nullable();
            $table->string('created_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
