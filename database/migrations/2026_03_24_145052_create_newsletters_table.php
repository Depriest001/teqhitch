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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('url')->nullable();
            $table->string('url_text')->nullable();
            $table->longText('content'); // HTML email body
            $table->enum('status', ['draft', 'scheduled', 'sending', 'completed'])
                ->default('draft');
            $table->timestamp('send_at')->nullable(); // for scheduling
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
