<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            "course_id" => $this->id,
            "course_name" => $this->course_name,
            "course_detail" => $this->course_detail
        ];
    }
}
