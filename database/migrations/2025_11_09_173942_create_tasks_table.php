<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();

        // Which client the task is for
        $table->foreignId('client_id')->constrained()->cascadeOnDelete();

        // Which user (team member) this task is assigned to
        $table->foreignId('assigned_to_id')->constrained('users')->cascadeOnDelete();

        // What to do
        $table->text('description');

        // Application targets
        $table->integer('target_applications')->default(0);
        $table->integer('completed_applications')->default(0);

        // Status
        $table->boolean('is_active')->default(true);
        $table->string('status', 20)->default('todo'); // todo / in_progress / done

        // Optional dates
        $table->timestamp('date_created')->nullable();
        $table->timestamp('date_completed')->nullable();

        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
