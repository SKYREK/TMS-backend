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
        Schema::create('vehicle_repairs', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_reg_no')->constrained();
            $table->string('monitored_by')->constrained();
            $table->string('title');
            $table->string('description');
            $table->decimal('cost', 8, 2);
            $table->date('date')->default(date('Y-m-d'));
            $table->string('bill_image');
            $table->foreign('vehicle_reg_no')->references('reg_no')->on('vehicles')->onDelete('cascade');
            $table->foreign('monitored_by')->references('username')->on('common_users')->onDelete('cascade');
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
        Schema::dropIfExists('vehicle_repairs');
    }
};
