<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestResource;
use App\Models\Question;
use App\Models\Test;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $class = Arr::get($request->all(),'class','');
        $course = Arr::get($request->all(),'course','');
        if($class != "" && $course != "") {
            $test = Test::with([
                "class" => function($query) {
                    $query->select(['id','class_name']);
                },
                "course" => function($query) {
                    $query->select(['id','course_name']);
                }
            ])->where('class_id', $class)
            ->where('course_id', $course)->paginate(10,['id','test_name','course_id','class_id'],'page');
            return TestResource::collection($test);
        }
        $test = Test::with([
            "class" => function($query) {
                $query->select(['id','class_name']);
            },
            "course" => function($query) {
                $query->select(['id','course_name']);
            }
        ])->paginate(10,['id','test_name','course_id','class_id'],'page');
        return TestResource::collection($test);
    }
    //chưa có get list test của (class, course) đâu

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $this->ValidateData($request);
        if($valid != true) {
            return $valid->errors();
        }
        $test = Test::create([
            "test_name" => $request->test_name,
            "course_id" => $request->test_course,
            "class_id" => $request->test_class,
            "who_created" => $request->user()->id
        ]);

        $questions = Question::whereIn('id',$request->test_questions)->get(['id']);
        foreach ($questions as $key => $question) {
            $questions_in_test[] = $question->id;
        }

        $test->question()->attach($questions_in_test);

        return response()->json(["message" => "Create Sucessfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = Test::where('id',$id)->with([
            "question" => function($query) {
                $query->select(['id','question_content','number_of_answer','is_multiple_choice'])->with([
                    "answer" => function($query) {
                        $query->select(['id','question_id','answer_content','is_correct']);
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
        return new TestResource($test[0]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid = $this->ValidateData($request);
        if($valid != true) {
            return $valid->errors();
        }
        $test = Test::find($id);
        $test->test_name = $request->test_name;
        $test->course_id = $request->test_course;
        $test->class_id = $request->test_class;
        $test->save();
        $questions = Question::whereIn('id',$request->test_questions)->get(['id']);
        foreach ($questions as $key => $question) {
            $questions_in_test[] = $question->id;
        }

        $test->question()->sync($questions_in_test);

        return response()->json(["message" => "Update Sucessfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Test::where('id',$id)->delete();
        } catch(Exception $e) {
            return $e;response()->json(["message" => "Can not delete because the relation"]);
        }
    }

    private function ValidateData($request)
    {
        $Validater = Validator::make($request->all(),[
            "test_name" => 'string|required',
            "test_course" => 'integer|required',
            "test_class" => 'integer|required',
            "test_questions" => 'array|required'
        ]);
        if($Validater->fails()) return $Validater;
        else return true;
    }
}
