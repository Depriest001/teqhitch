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
        Schema::create('system_info', function (Blueprint $table) {
            $table->id();

            $table->string('site_name')->nullable();
            $table->string('site_logo')->nullable();   // file path
            $table->string('favicon')->nullable();     // file path

            $table->string('support_email')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('timezone')->default('Africa/Lagos');

            $table->text('address')->nullable();
            $table->text('about')->nullable();

            $table->json('social_links')->nullable(); // e.g. { "facebook": "...", "twitter": "..." }

            $table->boolean('maintenance_mode')->default(false);
            $table->boolean('registration_open')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_info');
    }
};
