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
            'email' => 'admin@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $user = User::create([
            'name' => 'User',
            'email' => 'user@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);

        $adminRole = Role::findByName(\App\Acl::ROLE_ADMIN);
        $userRole = Role::findByName(\App\Acl::ROLE_USER);
        $admin->syncRoles($adminRole);
        $user->syncRoles($userRole);
    }
}
