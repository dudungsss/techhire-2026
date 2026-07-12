<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_invitations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_application_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('recruiter_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('message');

            $table->string('contact_info');

            $table->string('meeting_link')->nullable();

            $table->string('location')->nullable();

            $table->string('status')->default('pending');

            $table->timestamp('responded_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_invitations');
    }
};
