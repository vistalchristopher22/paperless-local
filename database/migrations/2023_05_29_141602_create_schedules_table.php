<?php

use App\Enums\ScheduleType;
use App\Models\ReferenceSession;
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
            $table->string('name');
            $table->datetime('date_and_time');
            $table->text('description')->nullable();
            $table->string('venue');
            $table->boolean('with_invited_guest')->default(0);
            $table->string('schedule')->nullable();
            $table->foreignIdFor(ReferenceSession::class);
            $table->enum('type', ScheduleType::values());
            $table->string('root_directory');
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
