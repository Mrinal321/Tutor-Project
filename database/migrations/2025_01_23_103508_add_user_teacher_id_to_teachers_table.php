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
        Schema::table('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('user_teacher_id')->nullable()->after('count');

            // Add the foreign key constraint
            $table->foreign('user_teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['user_teacher_id']);

            // Then drop the column
            $table->dropColumn('user_teacher_id');
        });
    }
};
