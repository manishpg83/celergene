<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('shipping_address_receiver_lname_1')->nullable()->after('shipping_address_receiver_name_1');
            $table->string('shipping_address_1_1')->nullable()->after('shipping_address_1');
            $table->string('shipping_city_1')->nullable()->after('shipping_address_1_1');
            $table->string('shipping_state_1')->nullable()->after('shipping_city_1');
            $table->string('shipping_phone_1', 50)->nullable()->after('shipping_state_1');
            $table->string('shipping_email_1')->nullable()->after('shipping_phone_1');
            $table->string('shipping_company_name_1')->nullable()->after('shipping_email_1');

            $table->string('shipping_address_receiver_lname_2')->nullable()->after('shipping_address_receiver_name_2');
            $table->string('shipping_address_2_1')->nullable()->after('shipping_address_2');
            $table->string('shipping_city_2')->nullable()->after('shipping_address_2_1');
            $table->string('shipping_state_2')->nullable()->after('shipping_city_2');
            $table->string('shipping_phone_2', 50)->nullable()->after('shipping_state_2');
            $table->string('shipping_email_2')->nullable()->after('shipping_phone_2');
            $table->string('shipping_company_name_2')->nullable()->after('shipping_email_2');

            $table->string('shipping_address_receiver_lname_3')->nullable()->after('shipping_address_receiver_name_3');
            $table->string('shipping_address_3_1')->nullable()->after('shipping_address_3');
            $table->string('shipping_city_3')->nullable()->after('shipping_address_3_1');
            $table->string('shipping_state_3')->nullable()->after('shipping_city_3');
            $table->string('shipping_phone_3', 50)->nullable()->after('shipping_state_3');
            $table->string('shipping_email_3')->nullable()->after('shipping_phone_3');
            $table->string('shipping_company_name_3')->nullable()->after('shipping_email_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_address_receiver_lname_1',
                'shipping_address_1_1',
                'shipping_city_1',
                'shipping_state_1',
                'shipping_phone_1',
                'shipping_email_1',
                'shipping_address_receiver_lname_2',
                'shipping_address_2_1',
                'shipping_city_2',
                'shipping_state_2',
                'shipping_phone_2',
                'shipping_email_2',
                'shipping_address_receiver_lname_3',
                'shipping_address_3_1',
                'shipping_city_3',
                'shipping_state_3',
                'shipping_phone_3',
                'shipping_email_3',
            ]);
        });
    }
};
