<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Test;
use Illuminate\Support\Arr;
class TestingController extends Controller
{
    public function testing(Request $request) {

        $valid = $this->ValidateData($request);
        if($valid != true) {
            return $valid->errors();
        }
        
        $test = Test::where('id',$request->test_id)->with([
            "question" => function($query) {
                $query->select(['id','question_content','number_of_answer','is_multiple_choice'])->with([
                    "answer" => function($query) {
                        $query->select(['id','question_id','answer_content','is_correct'])->where('is_correct',1);
                    }
                ]);
            },
            "class" => function($query) {
                $query->select(['id','class_name']);
            },
            "course" => function($query) {
                $query->select(['id','course_name']);
            }
        ])->get(['id','test_name','course_id','class_id']);

        foreach ($request->answers as $key => $question) {
            foreach ($question['answer'] as $key => $answer) {
                $answers[$question['question_id']][] = $answer;
            }
        }
        $test = $test[0];
        $grade = 0;
        foreach ($test->question as $key => $question) {
            $question_grade = 0;
            if(isset($answers[$question->id])) {
                foreach ($answers[$question->id] as $key => $answer_id) {
                    foreach ($question->answer as $key => $answer) {
                        if($answer->id == $answer_id) $question_grade += 1;
                    }
                }
                if($question_grade == count($question->answer)) $grade += 1;
            }
        }

        $grade = Grade::create([
            "trainee_id" => $request->user()->id,
            "test_id" => $request->test_id,
            "class_id" => $test->class_id,
            "grade" => $grade
        ]);
        
        return response()->json(['message' => 'Submid sucessfully']);
    }

    public function view_grade_by_trainer(Request $request) {
        $class_id = Arr::get($request->all(),'class','');
        $course_id = Arr::get($request->all(),'course','');
        $test_id = Arr::get($request->all(),'test','');
        $full_name = Arr::get($request->all(),'full_name','');
        
        $grades = Grade::query();

        $grades->join('users','users.id','=','grades.trainee_id');
        $grades->join("tests",'tests.class_id','grades.class_id');
        $grades->join("courses",'tests.course_id','courses.id');
        $grades->join("classes",'classes.id','grades.class_id');
        if($full_name != "") {
            $grades->where('users.name','like','%'.$request->full_name.'%');
        }
        
        if($course_id != "") {
            $grades->where('tests.course_id',$course_id);
        }

        if($class_id != "") {
            $grades->where('grades.class_id',$class_id);
        }

        if($test_id != "") {
            $grades->where('grades.test_id',$class_id);
        }
        return $grades->paginate(10,[
            'users.id',
            'users.name', 
            'classes.id as class_id' ,
            'classes.class_name', 
            'tests.id as test_id',
            'tests.test_name',
            'courses.id as course_id',
            'courses.course_name',
            'grade'
        ]);
    }

    public function view_grade_by_trainee(Request $request) {
        $class_id = Arr::get($request->all(),'class','');
        $course_id = Arr::get($request->all(),'course','');
        $test_id = Arr::get($request->all(),'test','');

        $grades = Grade::query();

        $grades->join('users','users.id','=','grades.trainee_id');
        $grades->join("tests",'tests.class_id','grades.class_id');
        $grades->join("courses",'tests.course_id','courses.id');
        $grades->join("classes",'classes.id','grades.class_id');
        
        $grades->where('users.id',$request->user()->id);
        
        if($course_id != "") {
            $grades->where('tests.course_id',$course_id);
        }

        if($class_id != "") {
            $grades->where('grades.class_id',$class_id);
        }

        if($test_id != "") {
            $grades->where('grades.test_id',$class_id);
        }
        return $grades->get([
            'users.id',
            'users.name', 
            'classes.id as class_id' ,
            'classes.class_name', 
            'tests.id as test_id',
            'tests.test_name',
            'courses.id as course_id',
            'courses.course_name',
            'grade'
        ]);
    }
    private function ValidateData($request)
    {
        $Validater = Validator::make($request->all(),[
            "test_id" => 'integer|required',
            "answers" => 'array|required'
        ]);
        if($Validater->fails()) return $Validater;
        else return true;
    }
}
