<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_master', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->date('invoice_date');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('shipping_address');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->text('remarks')->nullable();
            $table->enum('payment_mode', ['Credit Card', 'Bank Transfer', 'Cash']);
            $table->enum('invoice_status', ['Pending', 'Paid', 'Cancelled'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_master');
    }
};