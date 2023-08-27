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
        Schema::create('classroom_work_user', function (Blueprint $table) {
            $table->foreignId('classroom_work_id')
            ->constrained()->cascadeOnDelete();

            $table->foreignId('user_id')
            ->constrained()->cascadeOnDelete();

            $table->float('grade')->nullable();
            $table->timestamp('submited_at')->nullable();
            $table->enum('status' , ['assigned' , 'draft' , 'submited' , 'return'])
            ->default('assigned');

            $table->timestamp('created_at')->nullable();
            $table->primary(['classroom_work_id' , 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_work_user');
    }
};