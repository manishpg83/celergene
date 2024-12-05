<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('delivery_order_details', function (Blueprint $table) {
            $table->decimal('unit_price', 10, 2)->nullable()->after('quantity');
            $table->decimal('discount', 5, 2)->default(0)->nullable()->after('unit_price');
            $table->decimal('total', 10, 2)->nullable()->after('discount');
            $table->foreignId('order_detail_id')->nullable()->after('total')->constrained('order_details');
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventory')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('delivery_order_details', function (Blueprint $table) {
            $table->dropForeign(['order_detail_id']);
            $table->dropForeign(['inventory_id']);
            $table->dropColumn([
                'unit_price',
                'discount',
                'total',
                'order_detail_id',
                'inventory_id'
            ]);
        });
    }
};
