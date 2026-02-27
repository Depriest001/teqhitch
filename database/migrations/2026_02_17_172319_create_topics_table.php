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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('academic_level', ['BSc', 'MSc', 'PhD']);
            $table->enum('paper_type', ['seminar', 'project']);
            $table->string('department');
            $table->unsignedInteger('usage_count')->default(0);
            $table->decimal('average_rating', 2, 1)->default(0);
            $table->enum('status',['active','inactive','deleted'])->default('active');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
