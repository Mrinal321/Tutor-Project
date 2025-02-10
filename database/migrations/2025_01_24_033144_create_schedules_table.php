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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Event or class title
            $table->string('duration');
            $table->unsignedBigInteger('teacher_id'); // Foreign key for the teacher
            $table->timestamp('start_time')->change(); // Start time of the event
            $table->timestamp('end_time')->change(); // End time of the event
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
