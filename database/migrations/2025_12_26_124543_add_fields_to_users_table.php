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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique()->after('email');
            $table->string('phone')->nullable()->after('google_id');
            $table->string('avatar')->nullable()->after('phone');
            $table->enum('role', ['instructor','student'])->default('student')->after('avatar');
            $table->enum('status', ['active','suspended','deleted'])->default('active')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id','phone','avatar','role','status']);
        });
    }
};
