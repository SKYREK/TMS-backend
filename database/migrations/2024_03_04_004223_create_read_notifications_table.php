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
        Schema::create('read_notifications', function (Blueprint $table) {
            //composite primary key for username and notficationId
            $table->string('username');
            $table->unsignedBigInteger('notification_id');
            $table->primary(['username', 'notification_id']);
            $table->foreign('username')->references('username')->on('common_users')->onDelete('cascade');
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
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
        Schema::dropIfExists('read_notifications');
    }
};
