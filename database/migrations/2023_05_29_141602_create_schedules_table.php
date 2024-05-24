<?php

use App\Enums\ScheduleType;
use App\Models\BoardSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->datetime('date_and_time');
            $table->text('description')->nullable();
            $table->string('venue');
            $table->string('schedule')->nullable();
            $table->string('reference_session');
            $table->enum('type', ScheduleType::values());
            $table->foreignIdFor(BoardSession::class, 'order_of_business')->nullable();
            $table->string('root_directory')->nullable();
            $table->string('minutes_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
