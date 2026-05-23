<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinic_id')->constrained()->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('day_of_week')->nullable()->comment('0=Sunday, 1=Monday ... 6=Saturday, null=all days');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
