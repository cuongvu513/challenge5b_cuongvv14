<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->string('file_path');
            $table->string('original_name');
            $table->timestamps();

            $table->unique(['student_id', 'assignment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
