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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            //booking id
            $table->foreignId('booking_id')->constrained();
            //amount
            $table->decimal('amount', 8, 2);
            //date
            $table->date('date')->default(date('Y-m-d'));
            //card number
            $table->string('card_number');
            //card holder name
            $table->string('card_holder_name');
            //card expiry date
            $table->date('card_expiry_date');
            //card cvv
            $table->string('card_cvv');
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
        Schema::dropIfExists('payments');
    }
};
