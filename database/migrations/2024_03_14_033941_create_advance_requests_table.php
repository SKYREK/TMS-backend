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
        Schema::create('advance_requests', function (Blueprint $table) {
            $table->id();
            //username
            $table->string('username')->constrained();
            //date
            $table->date('date');
            //description
            $table->text('description');
            //status
            $table->string('status')->default('pending');
            //revieved_by
            $table->string('revieved_by')->constrained()->nullable();
            //amount
            $table->decimal('amount', 8, 2);
            //remarks
            $table->text('remarks')->nullable();
            $table->timestamps();
            //foreign
            $table->foreign('username')->references('username')->on('drivers');
            $table->foreign('revieved_by')->references('username')->on('common_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advance_requests');
    }
};
