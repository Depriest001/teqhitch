<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('newsletter_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('newsletter_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('subscriber_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('status', ['pending', 'sent', 'failed'])
                ->default('pending');

            $table->timestamp('sent_at')->nullable();
            $table->text('error')->nullable();

            $table->timestamps();

            // Prevent duplicate sending
            $table->unique(['subscriber_id']);

            // Performance index
            $table->index(['status', 'newsletter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_logs');
    }
};
