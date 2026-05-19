<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_question_bank_refs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('question_bank_question_id')->constrained('question_bank_questions')->cascadeOnDelete();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->unique(['assignment_id', 'question_bank_question_id'], 'assignment_qb_ref_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_question_bank_refs');
    }
};
