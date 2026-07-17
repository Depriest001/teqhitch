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
        Schema::create('enrollment_applications', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to your existing courses table
            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->onDelete('cascade');

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            
            // Selection preferences (e.g., onsite, online)
            $table->string('mode')->default('onsite');
            
            // Application Processing Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();

            /**
             * Anti-Redundancy Safeguard:
             * This composite dynamic index prevents an individual from submitting 
             * multiple duplicate applications for the exact same course program.
             */
            $table->unique(['email', 'course_id'], 'uidx_email_course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_applications');
    }
};