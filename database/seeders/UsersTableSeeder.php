<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $userList = ['Ta Thi Thuy','Nguyen Xuan Vung','Nguyen Ngoc Linh','Nguyen Minh Thu','Nguyen Tien Viet','Nguyen Tien Nam','Nguyen Ngoc Lien','Nguyen Thu Hang','Nguyen Duc Thu'];
      foreach($userList as $fullName)  {
        $name = str_replace(' ','_',$fullName);
        User::create([
             'name'=>$fullName,
             'email'=>strtolower($name) . '@veho-work.com',
             'password'=>Hash::make('password'),
        ]);
      }
    }
}
