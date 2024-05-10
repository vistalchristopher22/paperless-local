<?php

use App\Enums\DisplayScheduleType;
use App\Enums\ScheduleType;
use App\Enums\ScreenDisplayStatus;
use App\Models\ReferenceSession;
use App\Models\Schedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('screen_displays', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Schedule::class);
            $table->integer('screen_displayable_id');
            $table->string('screen_displayable_type');
            $table->bigInteger('duration')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->enum('type', DisplayScheduleType::values());
            $table->enum(column: 'status', allowed: ScreenDisplayStatus::values());
            $table->unsignedBigInteger('index')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screen_displays');
    }
};
