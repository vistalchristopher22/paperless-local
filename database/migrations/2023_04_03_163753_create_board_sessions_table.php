<?php

use App\Enums\BoardSessionStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('board_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('file_path')->nullable();
            $table->string('unassigned_title')->nullable();
            $table->text('unassigned_business')->nullable();
            $table->string('announcement_title')->nullable();
            $table->text('announcement_content')->nullable();
            $table->enum('status', BoardSessionStatus::values())->default(BoardSessionStatus::UNLOCKED->value);
            $table->unsignedBigInteger('is_published')->default(0);
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
