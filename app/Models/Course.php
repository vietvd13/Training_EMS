<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $guard_name = 'api';
    public $timestamps = false;
    protected $fillable = [
        "course_name",
        "is_assigned",
        "course_detail"
    ];
    protected $hidden = ['pivot'];
    
    public function classes() {
        return $this->belongsToMany('App\Models\Classs','class_course','course_id','class_id');
    }
}
