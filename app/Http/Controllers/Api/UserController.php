<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Role;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $name = Arr::get($request->all(),'name','');
        if($name == "") {
            $users = User::paginate(10,['*']);
            return UserResource::collection($users);
        }  else {
            $users = User::where('name','LIKE','%' . $name . '%')->paginate(10,['*']);
            return UserResource::collection($users);
        }
    }

    //Tên, tài khoản, tuổi, ngày sinh, trình đọ học vấn, ngôn ngữ lập trình, điểm TOEIC, kinh nghiệm chi tiết, bộ phần làm việc, vị trí...
    // Trainer: Tên, External or Internal type, sdt, email, địa chỉ...

    public function get_trainee_class(Request $request, $id) {
        $user = User::where("id",$id)->with([
            "classes" => function ($query) {
                $query->select(['id','class_name']);
            },
            "classes_trainer" => function ($query) use($id) {
                $query->select(['id','class_name']);
            }
        ])->get(['id','name','email']);
        return $user[0];
    }

    public function get_trainee_trainer_for_staff(Request $request) {
        $name = Arr::get($request->all(),'name','');
        if($name == "") {
            $users = User::role(['trainee','trainer'])->paginate(10,['*']);
            return UserResource::collection($users);
        }  else {
            $users = User::role(['trainee','trainer'])->where('name','LIKE','%' . $name . '%')->paginate(10,['*']);
            return UserResource::collection($users);
        }
    }
    
    public function get_trainer_courses_in_class(Request $request,$id) {
        $trainer_id = Arr::get($request->all(),'trainer_id','');
        if($trainer_id == "") $trainer_id = $request->user()->id;
        $user = User::where("id",$trainer_id)->with([
            "classes_trainer" => function ($query) use($id) {
                $query->with([
                    "course" => function ($query) {
                        $query->select(['id','course_name']);
                    }
                ]);
                $query->select(['id','class_name'])->where('id',$id);
            }
        ])->get(['id','name','email']);
        return $user[0]->classes_trainer[0];
    }

    public function get_trainer() {
        $users = User::query();
        return $users->role('trainer')->get(['id','email','name']);
    }
    public function get_trainee() {
        $users = User::query();
        return $users->role('trainee')->get(['id','email','name']);
    }
    
    public function store(Request $request)
    {
        $valid = $this->ValidateData($request);
        if($valid != true) {
            return $valid->errors();
        }
        $role = Role::find($request->user_role);
        $user = User::create([
            'name' => $request->user_full_name,
            'email' => $request->user_account,
            'password' => Hash::make($request->user_password),
            "birthday" => $request->user_birthday,
            "education_level" => $request->user_education_level,
            "toeic_grade" => $request->user_toeic_grade,
            "exp_detail" => $request->user_exp_detail,
            "department" => $request->user_department,
            "ex_in_ternal" => $request->user_ex_in_ternal,
            "address" => $request->user_address,
            "position" => $request->user_position,
            "major_programing" => $request->user_major_programing,
            "phone" => $request->user_phone
        ]);
        $user->syncRoles($role->name);
        return response()->json(['message' => "create sucessfully"]);
    }
    public function show($id)
    {
        try {
            return new UserResource(User::find($id));
        } catch (Exception $e) {
            return response()->json(["message" => "There is no data mutch"]);
        }
    }
    public function update(Request $request, $id)
    {
        $valid = $this->ValidateData($request);
        if($valid != true) {
            return $valid->errors();
        }
        $role = Role::find($request->user_role);
        $user = User::find($id);
        $user->name = $request->user_full_name;
        $user->password = Hash::make($request->user_password);
        $user->birthday = $request->user_birthday;
        $user->education_level = $request->user_education_level;
        $user->toeic_grade = $request->user_toeic_grade;
        $user->exp_detail = $request->user_exp_detail;
        $user->department = $request->user_department;
        $user->ex_in_ternal = $request->user_ex_in_ternal;
        $user->address = $request->user_address;
        $user->position = $request->user_position;
        $user->major_programing = $request->user_major_programing;
        $user->phone = $request->user_phone;
        $user->save();
        $user->syncRoles($role->name);
        return response()->json(['message' => "Update sucessfully"]);
    }
   // Jus destroy one user
    public function destroy($id)
    {
        try {
            User::where('id',$id)->delete();
            return response()->json(['message' => "Delete sucessfully"]);
        } catch (Exception $e) {
            return response()->json(["message" => "Can not delete because relationship"]);
        }
    }
    private function ValidateData($request)
    {
        $Validater = Validator::make($request->all(),[
            "user_full_name" => 'string|required',
            "user_account" => 'string|required',
            "user_password" => 'string|required',
            "user_role" => 'integer|required',
            "user_education_level" => 'integer',
            "user_toeic_grade" => 'integer',
            "user_exp_detail" => 'string',
            "user_department" => 'string',
            "user_ex_in_ternal" => 'integer',
            "user_address" => 'string',
            "user_major_programing" => 'string',
            "user_position" => 'string'
        ]);
        if($Validater->fails()) return $Validater;
        else return true;
    }
}
