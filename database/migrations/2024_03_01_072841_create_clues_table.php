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
        Schema::create('clues', function (Blueprint $table) {
            $table->id();
            $table->string('clueKey')->unique();
            $table->string('title');
            $table->text('body');
            $table->text('footNote')->nullable();
            $table->string('unlockKey')->default('default');
            $table->string('unlockHint')->nullable();
            $table->integer('order')->default(0);
            $table->foreignId('treasure_hunt_id')->constrained('treasure_hunts','id')->cascadeOnDelete();
            $table->text('help')->nullable(); //Todo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clues');
    }
};
