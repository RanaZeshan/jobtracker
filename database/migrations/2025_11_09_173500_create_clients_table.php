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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company', 120)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('notes')->nullable();
            $table->string('google_sheet_id', 255)->nullable();
            $table->integer('target_applications')->default(0);
            $table->string('application_status')->default('active'); // active or paused
            $table->string('job_title')->nullable();
            $table->string('job_location')->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
