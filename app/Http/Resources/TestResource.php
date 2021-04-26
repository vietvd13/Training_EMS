<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->question)) {
            return [
                "test_id" => $this->id,
                "test_name" => $this->test_name,
                "test_class" => $this->class->id,
                "test_course" => $this->course->id,
                "test_questions" => $this->question
            ];
        } else {
            return [
                "test_id" => $this->id,
                "test_name" => $this->test_name,
                "test_class" => $this->class->id,
                "test_course" => $this->course->id
            ];
        }
    }
}
