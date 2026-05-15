<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('class_code');
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->string('segment')->nullable()->after('description');
            $table->string('link_url')->nullable()->after('file_path');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->string('segment')->nullable()->after('description');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('segment')->nullable()->after('duration_minutes');
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['segment', 'link_url']);
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('segment');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('segment');
        });
    }
};
