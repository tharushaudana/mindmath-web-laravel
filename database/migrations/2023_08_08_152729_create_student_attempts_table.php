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
        Schema::create('student_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->nullable(false);
            $table->unsignedBigInteger('student_id')->nullable(false);
            $table->float('marks', 4, 2)->default(0);
            $table->timestamp('expire_at')->nullable(false);
            $table->timestamp('finished_at')->nullable(true);
            $table->timestamps();
            $table->foreign('test_id')
                ->references('id')
                ->on('tests')
                ->onDelete('cascade');
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attempts');
    }
};
