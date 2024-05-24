sl<?php

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
            Schema::create('sanggunian_members', function (Blueprint $table) {
                $table->id();
                $table->string('fullname');
                $table->string('lastname')->nullable();
                $table->string('district');
                $table->string('sanggunian');
                $table->text('official_title')->nullable();
                $table->string('profile_picture')->default('no_image.png');
                $table->string('unique_id')->unique()->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('sanggunian_members');
        }
    };
