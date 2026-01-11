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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('NGN');

            $table->string('reference')->unique(); // transaction reference
            $table->enum('status', ['pending','success','failed','refunded','deleted'])
                ->default('pending');

            $table->json('meta')->nullable(); // optional extra data

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id','course_id']); // prevents paying twice
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
