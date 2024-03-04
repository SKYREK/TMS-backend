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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->string('reg_no')->primary()->unique();
            $table->string('make');
            $table->string('model');
            $table->string('category')->constrained();
            $table->decimal('milage', 20, 0)->default(0);
            $table->integer('yom')->default(0);
            $table->integer('yor')->default(0);
            $table->string('description');
            $table->string('image');
            $table->string('type')->default('common');
            $table->timestamps();
            $table->foreign('category')->references('name')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
