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
                ->constrained('students')
                ->restrictOnDelete();

            // Polymorphic: could be a Course, a SiwesTrack, or anything else later
            $table->nullableMorphs('payable'); // creates payable_type + payable_id, indexed

            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('NGN');
            $table->string('gateway')->default('strowallet');

            $table->string('reference')->unique();
            $table->enum('status', ['pending','success','failed','refunded'])
                ->default('pending');

            $table->json('meta')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'payable_type', 'payable_id']);
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
