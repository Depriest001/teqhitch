<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Human-readable ID shown on ID cards, certificates, etc.
            // e.g. TQH-STU-000042
            $table->string('student_id')->unique();

            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone', 20)->unique();
            $table->string('password')->nullable();
            $table->string('google_id')->nullable()->unique();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('study_mode', ['onsite', 'online'])->default('onsite');
            $table->enum('status', ['active', 'inactive', 'graduated', 'suspended'])->default('active');
            $table->enum('source', ['siwes', 'enrollment', 'manual'])->default('manual');
            $table->foreignId('siwes_application_id')
                ->nullable()
                ->constrained('siwes_applications')
                ->nullOnDelete();
            $table->foreignId('enrollment_application_id')
                ->nullable()
                ->constrained('enrollment_applications')
                ->nullOnDelete();

            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};