<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $trainees = [];
        foreach ($this->trainee as $index => $trainee) {
            $trainees[] = [
                "trainee_id" => $trainee['id'],
                "trainee_name" => $trainee['name'],
                "trainee_email" => $trainee['email']
            ];
        }
        $courses = [];
        foreach ($this->course as $index => $course) {
            $courses[] = [
                "courese_id" => $course['id'],
                "course_name" => $course['course_name']
            ];
        }
        $trainer = [];
        $is_assigned = false;
        if(isset($this->trainer[0])) {
            $trainer = [
                "trainer_id" => $this->trainer[0]['id'],
                "trainee_name" => $this->trainer[0]['name'],
                "trainee_email" => $this->trainer[0]['email']
            ];
            $is_assigned = true;
        }

        return [
            "class_id" => $this->id,
            "class_name" => $this->class_name,
            "is_assigned" => $is_assigned,
            "class_trainer" => $trainer,
            "class_trainees" => $trainees,
            "class_course" => $courses
        ];
    }
}
