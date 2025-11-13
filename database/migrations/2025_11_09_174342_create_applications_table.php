<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('job_title', 120);
            $table->string('company_applied_to', 120);
            $table->string('job_link', 255)->nullable();
            $table->string('source_site', 120)->nullable();
            $table->string('location', 120)->nullable();
            $table->string('status', 30)->default('submitted');
            $table->timestamp('applied_on')->nullable();
            $table->float('earning')->default(0.0);
            $table->boolean('tailored_resume')->default(false);
            $table->string('resume_file', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
