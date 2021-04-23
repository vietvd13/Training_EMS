<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = "question_answer";
    protected $fillable = [
        "question_id",	
        "answer_content",	
        "is_correct"
    ];
    public function question() {
        return $this->belongsTo('App\Models\Question');
    }
}
