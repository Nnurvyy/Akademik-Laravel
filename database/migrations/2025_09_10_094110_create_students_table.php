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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->integer('entry_year');
            $table->unsignedBigInteger('user_id');  //unsignedBigInteger menyesuaikan dengan tipe data ID
            
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');  //FK
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
