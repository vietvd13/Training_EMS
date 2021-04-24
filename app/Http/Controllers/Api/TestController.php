<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classs;
use App\Models\Course;
use App\Models\Question;
use App\Models\Test;
use App\Models\Grade;
class TestController extends Controller
{
    public function index(Request $request) {
        // $test = User::role('trainee')
        //     ->with([
        //         "classes" => function ($query) {
        //             $query->select(['id','class_name']);
        //         }
        //     ])
        //     ->get(['id','name','email']);
        // return $test;

        // return Classs::with([
        //     "trainee" => function ($query) {
        //         $query->role('trainee')->select(['id','name','email']);
        //     }
        // ])->get(['id','class_name']);

        // return Classs::with([
        //     "course" => function ($query) {
        //         $query->select(['id','course_name']);
        //     }
        // ])->get(['id','class_name']);

        // return Course::with([
        //     "classes" => function ($query) {
        //         $query->select(['id','class_name']);
        //     }
        // ])->get(['id','course_name']);

        // return Test::with([
        //     "question" => function ($query) {
        //         $query->select(['id','question_content']);
        //     }
        // ])->get(['id']);
        
        // return Question::with([
        //     'answer' => function ($query) {
        //         $query->select(['id','answer_content','is_correct','question_id']);
        //     }
        // ])->get(['id','question_content']);
        // return Grade::with([
        //     "trainee" => function($query) {
        //         $query->select(['id','name','email']);
        //     },
        //     "test" => function($query) {
        //         $query->select(['id']);
        //     },
        //     "class" => function($query) {
        //         $query->select(['id','class_name']);
        //     },
        //     "course" => function($query) {
        //         $query->select(['id','course_name']);
        //     }
        // ])->get(['id','trainne_id','test_id','course_id']);
    } 
}
