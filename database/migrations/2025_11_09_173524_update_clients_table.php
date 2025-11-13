<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'company')) {
                $table->string('company', 120)->nullable()->after('name');
            }
            if (!Schema::hasColumn('clients', 'email')) {
                $table->string('email', 255)->nullable()->after('company');
            }
            if (!Schema::hasColumn('clients', 'notes')) {
                $table->text('notes')->nullable()->after('email');
            }
            if (!Schema::hasColumn('clients', 'google_sheet_id')) {
                $table->string('google_sheet_id', 255)->nullable()->after('notes');
            }
            if (!Schema::hasColumn('clients', 'target_applications')) {
                $table->integer('target_applications')->default(0)->after('google_sheet_id');
            }
            if (!Schema::hasColumn('clients', 'deleted')) {
                $table->boolean('deleted')->default(false)->after('target_applications');
            }
            if (!Schema::hasColumn('clients', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable()->after('deleted');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'company',
                'email',
                'notes',
                'google_sheet_id',
                'target_applications',
                'deleted',
                'deleted_at',
            ]);
        });
    }
};
