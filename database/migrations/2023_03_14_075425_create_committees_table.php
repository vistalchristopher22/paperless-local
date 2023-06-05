<?php

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->datetime('session_schedule')->nullable();
            $table->integer('display_index')->nullable();
            $table->bigInteger('priority_number')->unique();
            $table->unsignedBigInteger('lead_committee')->nullable();
            $table->foreign('lead_committee')->references('id')->on('agendas');
            $table->unsignedBigInteger('expanded_committee')->nullable();
            $table->foreign('expanded_committee')->references('id')->on('agendas');
            $table->string('file_path')->nullable();
            $table->longText('content')->charset('utf8mb4')->nullable();
            $table->date('date')->now();
            $table->boolean('invited_guests')->default(0);
            $table->enum('status', ['locked', 'review']);
            $table->foreignIdFor(User::class, 'submitted_by');
            $table->foreignIdFor(Schedule::class)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committees');
    }
};
