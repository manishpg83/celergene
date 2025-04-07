<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('brand');
            $table->string('product_img')->nullable();
            $table->string('product_name');
            $table->string('invoice_description');
            $table->string('product_category');
            $table->string('origin');
            $table->string('batch_number')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('currency');
            $table->decimal('unit_price', 10, 2);
            $table->text('remarks_notes')->nullable();
            $table->text('description');
            $table->boolean('is_online')->default(false);
            $table->string('created_by');
            $table->string('modified_by');
            $table->softDeletes();
            $table->timestamps();
        });

        // Add default product
        DB::table('products')->insert([
            'id' => 1,
            'product_code' => 'DEFAULT001',
            'brand' => 'Default Brand',
            'product_category' => 'General',
            'invoice_description' => 'Other',
            'product_name' => 'Other',
            'origin' => 'Unknown',
            'batch_number' => 'B0001',
            'expire_date' => now()->addYears(1),
            'currency' => 'USD',
            'unit_price' => 0.00,
            'description' => 'Default product entry',
            'created_by' => 'System',
            'modified_by' => 'System',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
