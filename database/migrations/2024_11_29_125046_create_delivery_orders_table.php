<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreignId('order_invoice_id')->constrained('order_invoice')->onDelete('cascade');
            $table->string('delivery_number', 20);
            $table->string('tracking_number')->nullable();
            $table->string('tracking_url')->nullable();
            $table->decimal('received_quantity', 10, 2)->nullable();
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->date('delivery_date');
            $table->enum('status', ['Pending', 'Shipped', 'Delivered', 'Cancelled'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('modified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')
                  ->references('order_id')
                  ->on('order_master')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};