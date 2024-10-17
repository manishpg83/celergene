<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name'); // Textfield, Mandatory
            $table->string('country'); // Drop Down, Mandatory
            $table->text('remarks')->nullable(); // Textfield, Not Mandatory
            $table->string('created_by'); // Textfield, Mandatory
            $table->dateTime('created_date'); // Datetime, Mandatory
            $table->dateTime('modified_date'); // Datetime, Mandatory
            $table->softDeletes(); // For soft delete functionality
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
        Schema::dropIfExists('suppliers');
    }
};

