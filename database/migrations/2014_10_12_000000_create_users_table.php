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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('profile_image')->default('https://images.theconversation.com/files/552239/original/file-20231005-16-1flnlj.jpg?ixlib=rb-1.1.0&rect=0%2C26%2C5815%2C3844&q=20&auto=format&w=320&fit=clip&dpr=2&usm=12&cs=strip');
            $table->integer('max_pro_clues')->default(env('USER_INITIAL_PRO_CLUES'));
            $table->boolean('isAdmin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
