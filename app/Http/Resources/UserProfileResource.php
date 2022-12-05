<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'major' => $this->major,
            'university' => $this->university,
            'email' => $this->email,
            'user_id' => $this->profile->user_id ?? null,
            'age' => $this->profile->age ?? null,
            'year' => $this->profile->year ?? null,
            'minor' => $this->profile->minor ?? null,
            'hobbies' => $this->profile->hobbies ?? null,
            'interests' => $this->profile->interests ?? null,
            'profileImg' => $this->profile->profileImg ?? null,
            'following' => (bool) $this->followers->where('follower_id', auth()->id())->count(),
        ];
    }
}
