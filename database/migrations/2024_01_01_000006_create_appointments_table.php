<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinic_id')->constrained()->onDelete('cascade');
            $table->foreignId('slot_id')->constrained()->onDelete('cascade');
            $table->date('appointment_date');
            $table->string('appointment_type')->default('first_visit'); // first_visit / follow_up
            $table->string('status')->default('booked'); // booked / cancelled / completed
            $table->string('booking_ref')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
