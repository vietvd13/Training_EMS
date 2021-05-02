<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        "course_id",
        "test_name",
        "class_id",	
        "who_created"
    ];
    public $timestamps = false;
    public function question() {
        return $this->belongsToMany('App\Models\Question','test_question','test_id','question_id');
    }
    public function class() {
        return $this->hasOne('App\Models\Classs','id','class_id');
    }
    public function course() {
        return $this->hasOne('App\Models\Course','id','course_id');
    }
}
