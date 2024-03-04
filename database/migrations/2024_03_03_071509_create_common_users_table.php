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
        Schema::create('common_users', function (Blueprint $table) {
            $table->string('username')->primary()->unique();
            $table->string('name');
            $table->string('gender')->default('male');
            $table->string('password')->required();
            $table->string('account_type')->default('customer');
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
        Schema::dropIfExists('common_users');
    }
};
