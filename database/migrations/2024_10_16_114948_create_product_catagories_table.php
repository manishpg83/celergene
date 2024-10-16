<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCatagoriesTable extends Migration
{
    public function up()
    {
        Schema::create('product_catagories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->unique();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_catagories');
    }
}
