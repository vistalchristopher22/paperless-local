<?php

use App\Models\Legislation;
use App\Models\SanggunianMember;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('legislation_sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Legislation::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SanggunianMember::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legislation_sponsors');
    }
};
