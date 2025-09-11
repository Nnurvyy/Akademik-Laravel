<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Take extends Model
{
    protected $table = 'takes';
    protected $primaryKey = ['user_id', 'course_id'];
    protected $fillable = [
        'enroll_date'
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
