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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                ->constrained()
                ->onDelete('cascade');
            
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('cv_path')->nullable();
            $table->text('cover_letter')->nullable();
            $table->text('experience_summary')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->decimal('expected_salary', 12, 2)->nullable();

            $table->unsignedBigInteger('match_score')->default(0);

            $table->string('status')->default('pending'); // pending, reviewed, shortlisted, rejected, accepted

            $table->timestamps();

            $table->unique(['job_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
