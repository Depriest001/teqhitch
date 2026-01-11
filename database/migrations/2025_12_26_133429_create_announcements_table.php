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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('posted_by_id');
            $table->string('posted_by_type');

            $table->string('title');
            $table->text('message');

            $table->enum('type', ['general','course'])
                ->default('general');
                
            $table->enum('audience', [
                'everyone',      // Admin → All users
                'students',      // Admin → Students
                'instructors',   // Admin → Instructors
                'course_students'// Instructor/Admin → Students in a specific course
            ])->default('everyone');

            // 👇 Needed only if course related
            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses')
                ->nullOnDelete();
            
            $table->enum('status',['draft','published','deleted'])->default('published');

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
