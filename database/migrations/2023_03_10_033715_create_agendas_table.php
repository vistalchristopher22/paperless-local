<?php

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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('chairman')->nullable();
            $table->foreign('chairman')->references('id')->on('sanggunian_members');
            $table->unsignedBigInteger('vice_chairman')->nullable();
            $table->foreign('vice_chairman')->references('id')->on('sanggunian_members');
            $table->unsignedBigInteger('index');
            $table->unsignedBigInteger('sanggunian')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
