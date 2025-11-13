<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 120);
            $table->string('job_role', 120)->nullable();
            $table->integer('applications_requested');
            $table->string('resume_file', 255)->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 50)->default('Pending');
            $table->timestamp('date_submitted')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
