<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('recruiter_status')->nullable()->after('password');

            $table->string('phone')->nullable();
            $table->text('summary')->nullable();
            $table->string('cv_path')->nullable();

            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();

            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'recruiter_status',
                'phone',
                'summary',
                'cv_path',
                'github_url',
                'linkedin_url',
                'portfolio_url',
                'is_active',
            ]);
        });
    }
};