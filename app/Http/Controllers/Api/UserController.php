<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Resources\UserResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    const ITEM_PER_PAGE = 10;
    public function index(Request $request)
    {
         $searchParams =  $request->all();
         $limit = Arr::get($searchParams,'limit',static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams,'keyword','');
        $current_page = Arr::get($searchParams,'page',1);
        $query = User::query();
        if(!empty($keyword)){
            $query->where('name','LIKE','%' .$keyword. '%');
            $query->orWhere('email','LIKE','%' .$keyword. '%');
        }
            return UserResource::collection($query->paginate($limit,['*'],'page',$current_page));         
    }
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),
       array_merge($this->getValidationRules(),
                [
                    'password'=> ['required', 'min:6'],
                    'confirmPassword'=> 'same:password'
                ]
            )
        );
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors(),'message'=>'Request not correct format','statusCode'=>403]);
        } else {
            $data = $request->all();
           $newUser = User::create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>Hash::make($data['password']),
            ]);
             // Pagination information
             $queryParam =  $request->get('queryParam');
             $count = User::all()->count();
             $users = User::paginate($queryParam['limit'],['*'],'page',ceil($count/$queryParam['limit']));
            return response()->json(['data'=>$newUser,'pagination_info'=>$users,'statusCode'=>200]);
           }
    }
    public function show($id)
    {
        try{
            $userDB = User::findOrFail($id);
            return new UserResource($userDB);
        } catch(ModelNotFoundException $ex)
        {
            return response()->json(['error'=>'NOT FOUND','statusCode' =>404]);
        }
    }
   public function updateNewPassword(Request $request){
    try{
        $userDB = User::findOrFail($request ->get('userId'));
               $validator = Validator::make($request->all(),[
                'password' => 'required|min:6',
                'newPassword' => 'required|min:6',
                'confirmNewPassword'=>'same:newPassword'
               ]);
               if($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 'statusCode'=>403]);
               } else {
               //Check currentPassword is user's password in DB
                 $mathWithOldPassword = Hash::check($request->get('password' ),$userDB['password']);
                     if(!$mathWithOldPassword ) {
                       return response()->json(['error'=>'Old password not correct','statusCode'=>403]);
                     } else {
                     // Check create newPassword has different to old Password
                        if($request->get('password') == $request->get('newPassword')) {
                          $differentPass = 'NO';
                        } else {
                          $differentPass = 'YES';
                        }
                       $userDB ->password = Hash::make($request->get('newPassword'));
                       $userDB->save();
                      
                      return response()->json(['message'=>'UPDATE SUCCESS' , 'has_different_with_old_password' =>$differentPass,'statusCode' =>200]);
                     }
               }
           } catch(ModelNotFoundException $ex)
           {
               return response()->json(['error'=>'NOT FOUND','statusCode' =>404]);
           }
   }
    public function update(Request $request, $id)
    {
         try{
            $userDB = User::findOrFail($id);
             //Just update email, name
             $email =  $request->get('email');
             $name = $request->get('name');
             //Update name and email
             if(!empty($email)&&!empty($name)) {
                 $validator = Validator::make($request->all(),$this->getValidationRules());
                if($this->isExistEmail($email) && $email != $userDB->email ) {
                    return response()->json(['error'=>'Email is exist','statusCode' =>403]);
                }
                $userDB->email = $email;
                $userDB->name = $name;
                $userDB->save();
             }
             // Update avatar
             if($request->hasFile('avatar')){
                 $avatar = $request->file('avatar');
                 $request->validate([
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                 ]);
             $current_avatar = $userDB->avatar;
             $avatar_name =  $userDB->id.'_avatar'.time().'.'.$avatar->getClientOriginalExtension();
             $avatar->storeAs('public/avatars',$avatar_name);
             $userDB->avatar = $avatar_name;
             $userDB->save();
           
            // Old avatar will be remove
            if($current_avatar != 'default-avatar.jpg' || $current_avatar != null )
               Storage::delete(['public/avatars/'.$current_avatar]);
            }
            return response()->json(['data'=>$userDB,'message'=>'UPDATE SUCCESS','statusCode' =>200]);

        } catch(ModelNotFoundException $ex)
        {
            return response()->json(['error'=>'NOT FOUND','statusCode' =>404]);
        } catch(Exception $e)
        {
             return response()->json(['error'=>'UPDATE FAIL','statusCode' =>500]);
        }
    }
   // Jus destroy one user
    public function destroy($id)
    {
         try{
            $userDB = User::findOrFail($id);
             $userDB->delete();
            return response()->json(['message'=>'DELETE SUCCESS'],200);
        } catch(ModelNotFoundException $ex)
        {
            return response()->json(['error'=>'NOT FOUND','statusCode' =>404]);
        } catch(Exception $e) {
            return response()->json(['error'=>'External API call failed','statusCode' =>500]);
        }
    }
    private function getValidationRules()
    {
        return [
            'name'=>'required',
            'email'=>'required|email|unique:users',
        ];
    }
    private function isExistEmail($email) {
       $foundEmail = User::where('email',$email)->first();
       if($foundEmail){
           return true;
       }
       return false;
    }
}
