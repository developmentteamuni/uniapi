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
            'major' => $this->major ?? [],
            'university' => $this->university,
            'email' => $this->email,
            'user_id' => $this->profile->user_id ?? null,
            'age' => $this->profile->age ?? null,
            'year' => $this->profile->year ?? null,
            'others' => $this->profile != null ? OtherResources::collection($this->profile->interests) : null,
            'profileImg' => $this->profile->profileImg ?? 'https://ui-avatars.com/api/?name=' . $this->firstname . '+' . $this->lastname,
            'following' => (bool) $this->followers->where('follower_id', auth()->id())->count(),
        ];
    }
}
