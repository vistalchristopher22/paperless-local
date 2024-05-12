<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->date('time_in')->nullable();
            $table->date('time_out')->nullable();
            $table->enum('status', ['present', 'absent', 'late', 'on_official_business'])->default('absent');
            $table->foreignId('sanggunian_member_id')->on('sanggunian_members')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->on('schedules')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
