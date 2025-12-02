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
        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('assessment_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('assessment_option_id')->nullable()->constrained()->onDelete('cascade'); // if MCQ or True/False
            $table->text('answer_text')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->integer('marks_obtained')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
    }
};
