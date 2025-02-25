<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_master', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('order_number', 20)->nullable();
            $table->date('order_date');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('entity_id')->constrained('entities')->onDelete('restrict');
            $table->foreignId('currency_id')->constrained('currency')->onDelete('restrict');
            $table->string('shipping_address');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('freight', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->text('remarks')->nullable();
            $table->enum('payment_mode', ['Credit Card', 'Bank Transfer', 'Cash']);
            $table->enum('order_status', ['Pending', 'Paid', 'Cancelled'])->default('Pending');
            $table->enum('order_type', ['Regular','Zero Value','Partial','Online','Offline'])->default('Regular');
            $table->enum('workflow_type', ['standard', 'multi_delivery', 'consignment'])->default('standard');
            $table->foreignId('parent_order_id')->nullable()->constrained('order_master', 'order_id')->onDelete('set null');
            $table->boolean('is_initial_consignment')->default(false);
            $table->decimal('total_order_quantity', 10, 2)->nullable();
            $table->decimal('remaining_quantity', 10, 2)->nullable();
            $table->boolean('is_generated')->default(false);
            $table->string('actual_freight')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('modified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('payment_terms')->nullable();
            $table->enum('delivery_status', ['Pending', 'Shipped', 'Delivered', 'Cancelled'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_master');
    }
};
