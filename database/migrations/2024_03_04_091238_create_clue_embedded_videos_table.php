<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clue_embedded_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clue_id')->constrained('clues','id')->cascadeOnDelete();
            $table->enum('type',['youtube','other'])->default('youtube');
            $table->string('src');
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clue_embedded_videos');
    }
};
