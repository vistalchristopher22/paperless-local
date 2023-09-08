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
        Schema::create('committee_file_links', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('view_link');
            $table->string('public_path');
            $table->string('parent')->nullable();
            $table->integer('committee_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_file_links');
    }
};
