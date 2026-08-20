<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siwes_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();

            // Step 1 — Personal Information
            $table->string('full_name');
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('phone', 20);
            $table->string('email');
            $table->string('address');

            // Step 2 — Academic Information
            $table->string('institution');
            $table->string('department');
            $table->string('course_of_study');
            $table->string('level');
            $table->string('matric_number');
            $table->date('siwes_start_date');
            $table->date('siwes_end_date');
            $table->string('letter_ref_number')->nullable();

            // Step 3 — Placement Preference
            $table->foreignId('track_id')->constrained('siwes_tracks');
            $table->date('preferred_start_date');
            $table->enum('mode', ['physical', 'hybrid']);

            // Step 4 — Payment (Strowallet virtual account)
            $table->decimal('amount', 10, 2)->default(15000);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('virtual_account_number')->nullable();
            $table->string('virtual_account_bank')->nullable();
            $table->string('virtual_account_name')->nullable();
            $table->string('strowallet_customer_email')->nullable();
            $table->json('strowallet_raw_response')->nullable();

            $table->index(['email', 'level']);
            $table->index(['matric_number', 'level']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siwes_applications');
    }
};
