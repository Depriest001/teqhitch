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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

           $table->foreignId('enrollment_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->string('certificate_code')->unique(); // e.g. random string or UUID
            $table->string('thumbnail')->nullable();
            $table->string('file_path')->nullable();      // generated PDF path

            $table->timestamp('issued_at')->nullable();            
            $table->boolean('delete_status')->default(false);
            $table->timestamps();

           $table->unique('enrollment_id'); // one certificate per enrollment
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
