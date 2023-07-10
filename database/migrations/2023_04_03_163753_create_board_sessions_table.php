<?php

use App\Enums\BoardSessionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('board_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('file_path')->nullable();
            $table->string('unassigned_title')->nullable();
            $table->text('unassigned_business')->nullable();
            $table->string('announcement_title')->nullable();
            $table->text('announcement_content')->nullable();
            $table->enum('status', BoardSessionStatus::values())->default(BoardSessionStatus::UNLOCKED->value);
            $table->unsignedBigInteger('locked_by')->nullable();
            $table->unsignedBigInteger('is_published')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_sessions');
    }
};
