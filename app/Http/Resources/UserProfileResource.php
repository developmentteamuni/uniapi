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
            'user_id' => $this->id,
            'age' => $this->profile->age ?? null,
            'year' => $this->profile->year ?? null,
            'minor' => $this->profile != null ? MinorResource::collection($this->profile->minors) : [],
            'interests' => $this->profile != null ? InterestResource::collection($this->profile->interests) : [],
            'hobbies' => $this->profile != null ? HobbyResource::collection($this->profile->hobbies) : [],
            'profileImg' => $this->profile == null ? 'https://ui-avatars.com/api/?name=' . $this->firstname . '+' . $this->lastname : getenv('APP_URL') . 'public/profileImages/' . $this->profile->profileImg,
            'following' => (bool) $this->followers->where('follower_id', auth()->id())->where('user_id', $this->id)->count(),
            // 'follows_me' => (bool) $this->followers->where('user_id', auth()->id())->count(),
        ];
    }
}
