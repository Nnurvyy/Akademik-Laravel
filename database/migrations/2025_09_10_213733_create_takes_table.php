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
        Schema::create('takes', function (Blueprint $table) {
            $table->date('enroll_date');
            $table->unsignedBigInteger('student_id'); 
            $table->unsignedBigInteger('course_id');

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade'); //FK
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');  //FK

            $table->primary(['student_id', 'course_id']); //PK
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('takes');
    }
};
