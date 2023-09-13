<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->withoutWrapping();
        return [
            'id' => $this->id,
            'title' => $this->name, // $this refered to Classroom model
            'code' => $this->code,
            'meta' => [
                'section' => $this->section,
                'room' => $this->room,
                'subject' => $this->subject,
                'students_count' => $this->students_count
            ],
            'user' => [
                'name' => $this->user->name,
            ]
        ];

    }
}