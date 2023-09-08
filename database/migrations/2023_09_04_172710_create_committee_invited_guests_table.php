<?php

use App\Models\Committee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('committee_invited_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Committee::class)->constrained()->cascadeOnDelete();
            $table->text('fullname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_invited_guests');
    }
};
