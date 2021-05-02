<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Question;
use Exception;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Support\Arr;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $is_not_paginate = Arr::get($request->all(),'no_paginate','');
        if($is_not_paginate == 1) {
            return Question::get(['id','question_content']);
        }
        return Question::with([
            'answer' => function ($query) {
                $query->select(['id','answer_content','is_correct','question_id']);
            }
        ])->paginate(10,['id','question_content']);
    }

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
        $is_multiple_choice = 0;
        $answers = [];
        foreach ($request->question_answers as $key => $question) {
            if($question['is_correct'] == 1) {
                $is_multiple_choice += 1;
            }
            $answers[] = [
                "question_id" => -1,
                "answer_content" => $question['answer_content'],
                "is_correct" => $question['is_correct']
            ];
        }
        $question = Question::create([
            "question_content" => $request->question_content,
            "who_created" => $request->user()->id,
            "number_of_answer" => count($request->question_answers),
            "is_multiple_choice" => ($is_multiple_choice > 1) ? $is_multiple_choice : 0
        ]);
        foreach ($answers as $key => &$answer) {
            $answer['question_id'] = $question->id;
        }

        $question->answer()->insert($answers);

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
        return Question::with([
            'answer' => function ($query) {
                $query->select(['id','answer_content','is_correct','question_id']);
            }
        ])->where('id',$id)->get(['*']);
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
        $is_multiple_choice = 0;
        $answers = [];
        foreach ($request->question_answers as $key => $question) {
            if($question['is_correct'] == 1) {
                $is_multiple_choice += 1;
            }
            $answers[] = [
                "question_id" => -1,
                "answer_content" => $question['answer_content'],
                "is_correct" => $question['is_correct']
            ];
        }
        $question = Question::find($id);
        $question->question_content = $request->question_content;
        $question->who_created = $request->user()->id;
        $question->number_of_answer = count($request->question_answers);
        $question->is_multiple_choice = ($is_multiple_choice > 1) ? $is_multiple_choice : 0;
        $question->save();

        foreach ($answers as $key => &$answer) {
            $answer['question_id'] = $question->id;
        }
        $question->answer()->delete();
        $question->answer()->insert($answers);

        return response()->json(["message" => "Create Sucessfully"]);
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
            Question::where('id',$id)->delete();
        } catch (Exception $e) {
            return response()->json(['message' => "can not delete because relationship"]);
        }
    }

    private function ValidateData($request)
    {
        $Validater = Validator::make($request->all(),[
            "question_content" => 'string|required',
            "question_answers" => 'array|required'
        ]);
        if($Validater->fails()) return $Validater;
        else return true;
    }
}
