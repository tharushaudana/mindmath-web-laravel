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
        Schema::create('mcq_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mcq_test_id');
            $table->unsignedBigInteger('attempt_id');
            $table->text('question');
            $table->text('answers');
            $table->unsignedInteger('correct_answer');
            $table->timestamp('loaded_at')->nullable(true);
            $table->timestamps();
            $table->foreign('mcq_test_id')
                ->references('id')
                ->on('mcq_tests')
                ->onDelete('cascade');
            $table->foreign('attempt_id')
                ->references('id')
                ->on('student_attempts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcq_questions');
    }
};
