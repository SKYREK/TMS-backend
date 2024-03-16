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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->timestamps();
            $table->id();
            $table->string('username')->constrained();
            $table->string('revieved_by')->constrained()->nullable();
            $table->date('date');
            $table->string('description');
            $table->string('status')->default('pending');
            $table->string('remarks')->nullable();
            $table->foreign('username')->references('username')->on('common_users')->onDelete('cascade');
            $table->foreign('revieved_by')->references('username')->on('common_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_requests');
    }
};
