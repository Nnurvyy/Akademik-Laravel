<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Take extends Model
{
    protected $table = 'takes';
    public $timestamps = false;
    public $incrementing = false; // karena bukan auto increment
    protected $fillable = [
        'enroll_date',
        'student_id',
        'course_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}

