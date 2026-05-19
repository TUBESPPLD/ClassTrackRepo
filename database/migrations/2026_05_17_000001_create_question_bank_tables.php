<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_bank_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('type')->default('mcq'); // mcq | essay
            $table->text('question_text');

            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->char('correct_answer', 1)->nullable(); // a|b|c|d (for mcq)

            $table->text('explanation')->nullable();
            $table->timestamps();

            $table->index(['class_id', 'type']);
        });

        Schema::create('question_bank_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['class_id', 'name']);
        });

        Schema::create('question_bank_question_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_bank_question_id')->constrained('question_bank_questions')->cascadeOnDelete();
            $table->foreignId('question_bank_tag_id')->constrained('question_bank_tags')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['question_bank_question_id', 'question_bank_tag_id'], 'qb_question_tag_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_bank_question_tag');
        Schema::dropIfExists('question_bank_tags');
        Schema::dropIfExists('question_bank_questions');
    }
};
