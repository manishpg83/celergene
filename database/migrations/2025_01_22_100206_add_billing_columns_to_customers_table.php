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
            $table->string('billing_fname', 255)->nullable()->after('billing_address');
            $table->string('billing_lname', 255)->nullable()->after('billing_fname');
            $table->string('billing_address_2', 255)->nullable()->after('billing_lname');
            $table->string('billing_city', 255)->nullable()->after('billing_address_2');
            $table->string('billing_state', 255)->nullable()->after('billing_city');
            $table->string('billing_phone', 255)->nullable()->after('billing_state');
            $table->string('billing_email', 255)->nullable()->after('billing_phone');
            $table->string('billing_company_name', 255)->nullable()->after('billing_email');
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
                'billing_fname',
                'billing_lname',
                'billing_address_2',
                'billing_city',
                'billing_state',
                'billing_phone',
                'billing_email',
                'billing_company_name',
            ]);
        });
    }
};
