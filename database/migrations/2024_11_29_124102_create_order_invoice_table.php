<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20);
            $table->date('invoice_date')->nullable();
            $table->foreignId('order_id')->constrained('order_master', 'order_id')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('entity_id')->constrained('entities')->onDelete('restrict');
            $table->string('shipping_address');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('freight', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->text('remarks')->nullable();
            $table->string('payment_terms')->nullable();
            $table->enum('status', ['Draft', 'Confirmed', 'Partially Invoiced', 'Fully Invoiced', 'Cancelled'])->default('Draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('modified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('invoice_type', ['regular', 'consignment', 'split_delivery']);
            $table->enum('invoice_category', ['regular', 'shipping']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_invoice');
    }
};