<?php

namespace App\Http\Resources;

use App\Models\RoomImage;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'clean' => $this->clean,
            'sleep_schdeule' => $this->sleep_schdeule,
            'noise_level' => $this->noise_level,
            'lots_of_time_in_room' => $this->lots_of_time_in_room,
            'company' => $this->lots_of_time_in_room,
            'social' => $this->social,
            'study_location' => $this->study_location,
            'requirements' => $this->requirements,
            'campus' => $this->campus,
            'time_to_campus' => $this->time_to_campus,
            'sublease' => $this->sublease,
            'created_at' => $this->created_at,
            'image_url' => RoomImageResource::collection($this->roomImage),
        ];
    }
}
