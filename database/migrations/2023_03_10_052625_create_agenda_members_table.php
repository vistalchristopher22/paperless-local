<?php

use App\Models\Agenda;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agenda_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Agenda::class);
            $table->unsignedBigInteger('member');
            $table->foreign('member')->references('id')->on('sanggunian_members');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_members');
    }
};
