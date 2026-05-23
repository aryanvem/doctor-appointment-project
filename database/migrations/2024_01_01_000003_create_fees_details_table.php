<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinic_id')->constrained()->onDelete('cascade');
            $table->decimal('first_visit_fee', 8, 2)->default(0);
            $table->decimal('follow_up_fee', 8, 2)->default(0);
            $table->string('payment_mode')->default('Pay at Clinic'); // Pay at Clinic / Online
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees_details');
    }
};
