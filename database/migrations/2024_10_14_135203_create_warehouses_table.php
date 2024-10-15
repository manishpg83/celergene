<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('warehouse_name');
            $table->string('country');
            $table->string('type');
            $table->text('remarks')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->unsignedBigInteger('modified_by')->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
