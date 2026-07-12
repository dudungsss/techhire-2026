<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'recruiter_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('recruiter_status')->nullable()->after('password');
            });
        }

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');

        if (Schema::hasColumn('users', 'recruiter_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('recruiter_status');
            });
        }
    }
};