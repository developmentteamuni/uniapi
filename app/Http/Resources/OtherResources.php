<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OtherResources extends JsonResource
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
            'minor' => $this->minor ?? null,
            'hobbies' => $this->hobbies ?? null,
            'interests' => $this->interests ?? null,
            'major' => $this->major ?? null,
        ];
    }
}
