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
            $table->string('product_code')->unique();
            $table->string('brand');
            $table->string('product_name');
            $table->string('product_category');
            $table->string('origin');
            $table->string('batch_number');
            $table->date('expire_date');
            $table->string('currency');
            $table->decimal('unit_price', 10, 2);
            $table->text('remarks_notes')->nullable();
            $table->text('description');
            $table->string('created_by');
            $table->string('modified_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
