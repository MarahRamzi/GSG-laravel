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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable'); // allow any type of user to authenticate
            $table->string('name'); //store device name
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable(); // abilities of token (when use third party) provide authentication system to outside application
            $table->timestamp('last_used_at')->nullable(); // last use of token 
            $table->timestamp('expires_at')->nullable(); // time of end token
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};