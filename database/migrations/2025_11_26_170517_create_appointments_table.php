<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->string('user_name');
        $table->string('user_email');
        $table->string('user_contact');
        $table->json('services'); // store selected services
        $table->decimal('total_price', 10, 2);
        $table->date('appointment_date');
        $table->string('appointment_time');
        $table->enum('status', ['confirmed', 'canceled' , 'done'])->default('confirmed'); // auto-confirm
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
