<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Course extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $timestamps = false;
    protected $fillable = [
        'course_name',
        'credits',
    ];
    public function takes()
    {
        return $this->hasMany(Take::class, 'course_id', 'course_id');
    }
}
