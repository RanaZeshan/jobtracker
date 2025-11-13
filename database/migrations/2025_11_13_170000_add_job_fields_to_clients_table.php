<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('job_title')->nullable()->after('name');
            $table->text('job_description')->nullable()->after('job_title');
            $table->string('location')->nullable()->after('job_description');
            $table->string('job_type')->nullable()->after('location'); // Full-time, Part-time, Contract, etc.
            $table->string('experience_level')->nullable()->after('job_type'); // Entry, Mid, Senior
            $table->string('salary_range')->nullable()->after('experience_level');
            $table->boolean('is_public')->default(false)->after('salary_range'); // Show on public page
            $table->date('posted_date')->nullable()->after('is_public');
            $table->date('deadline')->nullable()->after('posted_date');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'job_title',
                'job_description',
                'location',
                'job_type',
                'experience_level',
                'salary_range',
                'is_public',
                'posted_date',
                'deadline',
            ]);
        });
    }
};
