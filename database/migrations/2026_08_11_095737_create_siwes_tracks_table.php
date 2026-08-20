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
        Schema::create('siwes_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // e.g. "Cybersecurity & Ethical Hacking"
            $table->decimal('price', 10, 2);  // per-track fee, floor enforced in code
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siwes_tracks');
    }
};
