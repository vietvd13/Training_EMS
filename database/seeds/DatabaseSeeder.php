<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = \App\Acl::roles();
        foreach ($roles as $role_name)
        {
            $role = Role::create(['name' => $role_name]);
        }
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        $staff = User::create([
            'name' => 'staff',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('staff'),
        ]);

        $trainer = User::create([
            'name' => 'trainer',
            'email' => 'trainer@gmail.com',
            'password' => Hash::make('trainer'),
        ]);
        
        $trainee = User::create([
            'name' => 'trainee',
            'email' => 'trainee@gmail.com',
            'password' => Hash::make('trainee'),
        ]);

        $adminRole = Role::findByName(\App\Acl::ROLE_ADMIN);
        $staffRole = Role::findByName(\App\Acl::ROLE_STAFF);
        $trainerRole = Role::findByName(\App\Acl::ROLE_TRAINER);
        $traineeRole = Role::findByName(\App\Acl::ROLE_TRAINEE);
        $admin->syncRoles($adminRole);
        $staff->syncRoles($staffRole);
        $trainer->syncRoles($trainerRole);
        $trainee->syncRoles($traineeRole);
    }
}
