<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    public $timestamps = false;
    protected $primaryKey = 'student_id';
    protected $fillable = [
        'entry_year',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function takes()
    {
        return $this->hasMany(Take::class, 'student_id', 'student_id');
    }

}
