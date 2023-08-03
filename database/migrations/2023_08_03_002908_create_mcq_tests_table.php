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
        Schema::create('mcq_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->nullable(false);
            $table->unsignedInteger('num_questions')->nullable(false);
            $table->unsignedInteger('dur_per')->nullable(false);
            $table->unsignedInteger('dur_extra')->default(0);
            //----
            $table->unsignedInteger('nplus')->nullable(false);
            $table->unsignedInteger('nminus')->nullable(false);
            $table->unsignedInteger('nmultiply')->nullable(false);
            $table->unsignedInteger('ndivition')->nullable(false);
            //----
            $table->string('operation_order')->default(null); // like "+,+,*,-" | NULL for random order
            $table->string('digits_order')->default(null); // like "1,2,2,3,1" | NULL for random order
            $table->boolean('shuffle_digits_order')->default(0);
            $table->timestamps();
            $table->foreign('test_id')
                ->references('id')
                ->on('tests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcq_tests');
    }
};
