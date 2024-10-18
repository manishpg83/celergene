<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_code')->constrained('products', 'id')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained('warehouses', 'id')->onDelete('cascade');
            $table->string('batch_number');
            $table->date('expiry');
            $table->integer('quantity');
            $table->integer('consumed')->default(0);
            $table->integer('remaining')->computed('quantity - consumed');
            $table->string('created_by');
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
