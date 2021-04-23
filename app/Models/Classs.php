<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classs extends Model
{
    //
    protected $table = "classes";

    protected $fillable = [
        "class_name",
        "is_assigned"
    ];

    protected $hidden = [
        'pivot'
    ];

    public function trainee() {
        return $this->belongsToMany('App\Models\User','class_trainee','class_id','trainee_id');
    }

    public function course() {
        return $this->belongsToMany('App\Models\Course','class_course','class_id','course_id');
    }
}
