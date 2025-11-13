<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_intakes', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->string('full_name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('employment_status', 50)->nullable();
            $table->string('job_titles', 255)->nullable();
            $table->string('experience_level', 50)->nullable();
            $table->string('education', 100)->nullable();
            $table->json('skills')->nullable();
            $table->json('job_type')->nullable();
            $table->string('locations', 255)->nullable();
            $table->string('salary', 50)->nullable();
            $table->string('availability', 50)->nullable();
            $table->string('visa_status', 50)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->text('career_goals')->nullable();
            $table->string('country', 100)->nullable();
            $table->json('languages')->nullable();
            $table->text('references')->nullable();
            $table->text('notes')->nullable();
            $table->string('resume_file', 255)->nullable();
            $table->string('cover_letter_file', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_intakes');
    }
};
