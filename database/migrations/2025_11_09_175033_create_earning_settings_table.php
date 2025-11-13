<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earning_settings', function (Blueprint $table) {
            $table->id();
            $table->float('base_earning')->default(20.0);
            $table->float('tailored_bonus')->default(20.0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earning_settings');
    }
};
