<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request) {
        $roles = Role::get();
        foreach ($roles as $key => $role) {
            $result[] = [
                "role_id" => $role['id'],
                "role_name" => $role['name']
            ];
        }
        if(isset($result)) return $result;
    }
}
