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
        Schema::create('manager_tokens', function (Blueprint $table) {
            $table->string('token_id', 500)->primary();
            $table->string('token');
            $table->string('otp_token')->unique();
            $table->enum('type', ['repassword', 'active', 'login', 'enable_2fa', 'disable_2fa']);
            $table->string('email');
            $table->timestamp('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_tokens');
    }
};
