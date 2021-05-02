<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->classes)) {
            return [
                "trainee_id" => $this->id,
                "trainee_name" => $this->name,
                "trainee_email" => $this->email,
                "trainee_classes" => ClassResource::collection($this->classes)
            ];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => array_map(
                function ($role) {
                    return $role['name'];
                },
                $this->roles->toArray()
            ),
            // 'permissions' => array_map(
            //     function ($permission) {
            //         return $permission['name'];
            //     },
            //     $this->getAllPermissions()->toArray()
            // ),
           'avatar' => $this->avatar, // collum avatar
        ];
    }
}
