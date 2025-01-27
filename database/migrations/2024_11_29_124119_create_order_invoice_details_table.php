<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_invoice_id')->constrained('order_invoice')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->integer('delivered_quantity')->default(0);
            $table->integer('invoiced_quantity')->default(0);
            $table->integer('sample_quantity')->default(0);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->string('manual_product_name', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_invoice_details');
    }
};