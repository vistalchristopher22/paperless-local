<?php

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
            $table->string('session_schedule');
            $table->bigInteger('priority_number')->unique();
            $table->unsignedBigInteger('lead_committee')->nullable();
            $table->foreign('lead_committee')->references('id')->on('agendas');
            $table->unsignedBigInteger('expanded_committee')->nullable();
            $table->foreign('expanded_committee')->references('id')->on('agendas');
            $table->string('file_path');
            $table->longText('content')->charset('utf8mb4')->nullable();
            $table->date('date')->now();
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
