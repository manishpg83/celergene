<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand'); // Field 1
            $table->string('product_name'); // Field 2
            $table->string('product_category'); // Field 3
            $table->string('origin'); // Field 4
            $table->string('batch_number'); // Field 5
            $table->date('expire_date'); // Field 6
            $table->string('currency'); // Field 7
            $table->decimal('unit_price', 10, 2); // Field 8
            $table->text('remarks_notes')->nullable(); // Allow it to be null
            $table->text('description'); // Updated: removed nullable
            $table->string('created_by'); // Field 10
            $table->string('modified_by'); // Field 12
            $table->softDeletes(); // Soft deletes
            $table->timestamps(); // Created at & Updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
