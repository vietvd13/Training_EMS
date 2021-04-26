<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $guard_name = 'api';

    protected $fillable = [
        "course_name",
        "is_assigned"
    ];
    protected $hidden = ['pivot'];
    
    public function classes() {
        return $this->belongsToMany('App\Models\Classs','class_course','course_id','class_id');
    }
}
