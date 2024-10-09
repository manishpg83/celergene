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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('address');
            $table->string('country');
            $table->string('postal_code');
            $table->string('business_reg_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('bank_account_name');
            $table->string('bank_account_number');
            $table->string('currency', 3);
            $table->string('bank_name');
            $table->text('bank_address');
            $table->string('bank_swift_code', 11)->nullable();
            $table->string('bank_iban_number', 34)->nullable();
            $table->string('bank_code')->nullable();
            $table->string('bank_branch_code')->nullable();
            $table->foreignId('created_by')->constrained('admins');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
