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
            'minor' => $this->minors != null ? MinorResource::collection($this->minors) : [],
            'interests' => $this->interests != null ? InterestResource::collection($this->interests) : [],
            'hobbies' => $this->hobbies != null ? HobbyResource::collection($this->hobbies) : [],
            'profileImg' => $this->profile == null ? 'https://ui-avatars.com/api/?name=' . $this->firstname . '+' . $this->lastname : getenv('APP_IMAGE_URL') . 'public/profileImages/' . $this->profile->profileImg,
            'following' => (bool) $this->followers->where('follower_id', auth()->id())->where('user_id', $this->id)->count(),
            // 'follows_me' => (bool) $this->followers->where('user_id', auth()->id())->count(),
        ];
    }
}
