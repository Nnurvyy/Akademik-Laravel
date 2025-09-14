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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('email')->unique();  // untuk Breeze
            $table->string('username', 15)->unique();  // string -> varchar(15)
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('full_name', 100); // string -> varchar(100)
            $table->rememberToken();  // untuk library Breeze
            $table->timestamps();  // untuk library Breeze
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
