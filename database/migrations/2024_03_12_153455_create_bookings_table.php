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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            //customer username
            $table->string('username')->constrained();
            //driver username
            $table->string('driver_username')->constrained();
            //date
            $table->date('date');
            //vehicle reg no
            $table->string('vehicle_reg_no')->constrained();
            //distance
            $table->integer('distance');
            //cost
            $table->decimal('cost', 8, 2);
            //payment status
            $table->string('payment_status')->default('pending');
            //remarks
            $table->string('remarks')->nullable();
            //foreign keys
            $table->foreign('username')->references('username')->on('common_users')->onDelete('cascade');
            $table->foreign('driver_username')->references('username')->on('common_users')->onDelete('cascade');
            $table->foreign('vehicle_reg_no')->references('reg_no')->on('vehicles')->onDelete('cascade');
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
        Schema::dropIfExists('bookings');
    }
};
