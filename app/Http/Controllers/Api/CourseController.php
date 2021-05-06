<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;
use App\Models\Course;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $is_paginate = Arr::get($request->all(),'full','');
        if($is_paginate == 1) {
            return Course::get(['id','course_name','course_detail']);
        }
        $courses = Course::paginate(10,['id','course_name','course_detail']);
        return CourseResource::collection($courses);
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

        Course::create([
            "course_name" => $request->course_name,
            "course_detail" => $request->course_detail
        ]);

        return response()->json([
            "message" => "create sucessfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        return new CourseResource($course);
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

        $course = Course::find($id);
        $course->course_name = $request->course_name;
        $course->course_detail = $request->course_detail;
        $course->save();
        return response()->json([
            "message" => "create sucessfully"
        ]);
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
            Course::where('id', $id)->delete();
        } catch (Exception $e){
            return [
                "message" => "Can not delete because relationship"
            ];
        }
    }

    private function ValidateData($request)
    {
        $Validater = Validator::make($request->all(),[
            "course_name" => 'string|required',
            "course_detail" => 'string|required'
        ]);
        if($Validater->fails()) return $Validater;
        else return true;
    }
}
