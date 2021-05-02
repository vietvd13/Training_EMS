<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        "trainee_id",
        "test_id",	
        "class_id",
        'grade'
    ];
    public $timestamps = false;
    public function trainee() {
        return $this->hasOne('App\Models\User','id','trainee_id');
    }
    public function test() {
        return $this->hasOne('App\Models\Test','id','test_id');
    }
    public function class() {
        return $this->hasOne('App\Models\Classs','id','class_id');
    }
}
