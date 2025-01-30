<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('order_master', 'order_id')->onDelete('cascade'); // Updated from order_id to order_id
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('manual_product_name')->nullable();
            $table->string('sample_quantity')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->integer('invoice_rem')->default(0);
            $table->integer('invoice_rem_sample')->default(0);
            $table->integer('sample_quantity_remaining')->default(0);
            $table->integer('remaining_quantity')->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_details');
    }
};
