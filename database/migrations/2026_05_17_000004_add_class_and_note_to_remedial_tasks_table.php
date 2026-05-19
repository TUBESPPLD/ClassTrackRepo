<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remedial_tasks', function (Blueprint $table) {
            $table->foreignId('class_id')
                ->nullable()
                ->after('assignment_id')
                ->constrained('classes')
                ->nullOnDelete();

            $table->text('note')->nullable()->after('deadline');

            $table->index(['class_id', 'student_id', 'assignment_id']);
        });
    }

    public function down(): void
    {
        Schema::table('remedial_tasks', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropConstrainedForeignId('class_id');
        });
    }
};
