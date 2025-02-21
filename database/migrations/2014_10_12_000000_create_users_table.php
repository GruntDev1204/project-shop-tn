<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('hash_code')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable()->default('https://firebasestorage.googleapis.com/v0/b/hotrung1204-36f50.appspot.com/o/Ngoc_Red%2Fdf.jpg?alt=media&token=813909dc-52e3-43d2-b2cd-51c1b912c44e');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 500)->nullable();
            $table->integer('status')->default(0);
            $table->boolean('is_enabled_2fa')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
