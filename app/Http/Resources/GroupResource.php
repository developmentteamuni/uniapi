<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'group_name' => $this->group_name,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'link' => $this->link,
            'entrace' => $this->entrace,
            'describe' => $this->describe,
            'attendance' => $this->attendance,
            'fee' => $this->fee,
            'group_type' => $this->group_type,
            'images' => GroupImageResources::collection($this->groupImage)
        ];
    }
}
