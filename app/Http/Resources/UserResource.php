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
            "birthday" => $this->birthday,
            "education_level" => $this->education_level,
            "toeic_grade" => $this->toeic_grade,
            "exp_detail" => $this->exp_detail,
            "department" => $this->department,
            "position" => $this->position,
            "ex_in_ternal" => $this->ex_in_ternal,
            "address" => $this->address,
            "major_programing" => $this->major_programing,
            "phone" => $this->phone
        ];
    }
}
