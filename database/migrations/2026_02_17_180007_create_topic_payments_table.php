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
        Schema::create('topic_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('payment_type'); // matches slug
            $table->decimal('amount', 10, 2);
            $table->string('reference')->unique();
            $table->json('meta')->nullable(); // optional extra data
            $table->foreignId('user_topic_id')->nullable();
            $table->enum('status', ['pending','success','failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_payments');
    }
};
