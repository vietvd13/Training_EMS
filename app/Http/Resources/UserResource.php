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
            "birthday" => $request->birthday,
            "education_level" => $request->education_level,
            "toeic_grade" => $request->toeic_grade,
            "exp_detail" => $request->exp_detail,
            "department" => $request->department,
            "ex_in_ternal" => $request->ex_in_ternal,
            "address" => $request->address
        ];
    }
}
