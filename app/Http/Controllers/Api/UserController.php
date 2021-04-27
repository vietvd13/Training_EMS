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
        $users = User::paginate(10,['*']);
        return UserResource::collection($users);
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
            "user_role" => 'integer|required'
        ]);
        if($Validater->fails()) return $Validater;
        else return true;
    }
}
