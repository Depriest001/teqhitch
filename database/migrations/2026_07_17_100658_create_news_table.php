<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();       // Announcement, Event, Partnership, Update
            $table->string('icon')->nullable();            // e.g. fas fa-trophy
            $table->string('image')->nullable();            // stored in uploads/
            $table->text('excerpt')->nullable();            // short card summary
            $table->longText('body');                       // full article content (HTML/markdown)
            $table->string('author')->default('Teqhitch Team');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};