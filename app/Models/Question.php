<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        "question_content",	
        "who_created",	
        "number_of_answer",	
        "is_multiple_choice"
    ];
    public $timestamps = false;
    protected $hidden = ['pivot'];

    public function test() {
        return $this->belongsTo('App\Models\Test','test_question','question_id','test_id');
    }

    public function answer() {
        return $this->hasMany('App\Models\Answer');
    }
}
