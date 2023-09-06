<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resolutions', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->unsignedBigInteger('author')->nullable();
            $table->foreign('author')->references('id')->on('sanggunian_members');
            $table->unsignedBigInteger('co_author')->nullable();
            $table->foreign('co_author')->references('id')->on('sanggunian_members');
            $table->unsignedBigInteger('type');
            $table->foreign('type')->references('id')->on('types');
            $table->date('session_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resolutions');
    }
};
