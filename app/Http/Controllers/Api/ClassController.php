<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassResource;
use Illuminate\Http\Request;
use App\Models\Classs;
use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_course_in_class(Request $request, $id) {
        // $course_in_class = Classs::with([
        //     "course" => function($query) {
        //         $query->select(['id','course_name']);
        //     }
        // ])->where('id',$id)->get(['id','class_name']);
       // return $course_in_class;
    }

    public function index()
    {
        $classes = Classs::with([
            "trainee" => function ($query) {
                $query->role('trainee')->select(['id','name','email']);
            },
            "trainer" => function($query) {
                $query->role('trainer')->select(['id','name','email']);
            },
            "course" => function($query) {
                $query->select(['id','course_name']);
            }
        ])->orderBy('failed_at','DESC')->paginate(10,['id','class_name']);
        
        return ClassResource::collection($classes);
    }

    public function assign_trainer(Request $request, $id) {
        if(!isset($request->class_trainer)) {
            return response()->json(['message'=> 'Invalid data, required class trainer id']);
        }
        $trainer = User::find($request->class_trainer);
        $class = Classs::find($id);
        $class->trainer()->sync($trainer->id);
        return response()->json(['message' => 'assigned sucessfully']);
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

        $trainees = User::whereIn('id',$request->class_students)->role('trainee')->get(['id']);
        if(count($trainees) != count($request->class_students)) {
            return [
                "class_students" => "Invalid, There are some ID is not trainee"
            ];
        }

        $courses = Course::whereIn('id',$request->class_courses)->get(['id']);
        if(count($courses) != count($request->class_courses)) {
            return [
                "class_students" => "Invalid, There are some ID is not Courses"
            ];
        }

        $class = Classs::create([
            "class_name" => $request->class_name
        ]);

        $trainees_list = [];
        foreach ($trainees as $index => $trainee) {
            $trainees_list[] = $trainee['id'];
        }

        $courses_list = [];
        foreach ($courses as $index => $course) {
            $courses_list[] = $course['id'];
        }

        $class->trainee()->attach($trainees_list);
        $class->course()->attach($courses_list);
        return $class;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $class = Classs::with([
            "trainee" => function ($query) {
                $query->role('trainee')->select(['id','name','email']);
            },
            "trainer" => function($query) {
                $query->role('trainer')->select(['id','name','email']);
            },
            "course" => function($query) {
                $query->select(['id','course_name']);
            }
        ])->where('id', $id)->get();
        return new ClassResource($class[0]);
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

        $trainees = User::whereIn('id',$request->class_students)->role('trainee')->get(['id']);
        if(count($trainees) != count($request->class_students)) {
            return [
                "class_students" => "Invalid, There are some ID is not trainee"
            ];
        }

        $courses = Course::whereIn('id',$request->class_courses)->get(['id']);
        if(count($courses) != count($request->class_courses)) {
            return [
                "class_students" => "Invalid, There are some ID is not Courses"
            ];
        }
       
        $class = Classs::find($id);
        $class->class_name = $request->class_name;
        $class->save();
        $trainees_list = [];
        foreach ($trainees as $index => $trainee) {
            $trainees_list[] = $trainee->id;
        }
        $courses_list = [];
        foreach ($courses as $index => $course) {
            $courses_list[] = $course->id;
        }
        $class->trainee()->sync($trainees_list);
        $class->course()->sync($courses_list);
        return [
            "message" => "Update Sucessfully"
        ];
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
            Classs::where('id', $id)->delete();
        } catch (Exception $e){
            return [
                "message" => "Can not delete because relationship"
            ];
        }
    }

    private function ValidateData($request)
    {
        $Validater = Validator::make($request->all(),[
            "class_name" => 'string|required',
            "class_students" => 'array|required',
            "class_courses" => 'array|required'
        ]);
        // if(!$Validater->fails() && isset($request->data))
        // {
        //     $DATA = "data.*.".$KEY->DAY_OFF->DATE_LIST.'.*.';
        //     $Validater = Validator::make($request->all(),[
        //         $DATA.$KEY->DAY_OFF->ID => 'integer',
        //         $DATA.$KEY->DAY_OFF->ROUTE_CODE => '|required|integer',
        //         $DATA.$KEY->DAY_OFF->EMPLOYEE_CODE => '|required|integer',
        //         $DATA.$KEY->DAY_OFF->DATE_LIST_DETAIL->DATE => '|required|date_format:Y-m-d',
        //         $DATA.$KEY->DAY_OFF->DATE_LIST_DETAIL->STATUS_ONE_DAY => '|required|integer',
        //         $DATA.$KEY->DAY_OFF->DATE_LIST_DETAIL->STATUS_FIRST_HALF_DAY => '|required|integer',
        //         $DATA.$KEY->DAY_OFF->DATE_LIST_DETAIL->STATUS_SECOND_HALF_DAY => '|required|integer'
        //     ]);
        // }
        if($Validater->fails()) return $Validater;
        else return true;
    }
}
