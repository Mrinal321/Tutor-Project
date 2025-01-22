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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade'); // References `teachers` table
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // References `users` table, nullable for anonymous comments
            $table->text('content'); // Comment text
            $table->timestamps(); // Created and Updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
