<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FriendsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $followers = [];
        foreach ($this->followers as $follower) {
            $followers[] = [
                'user_id' => $follower->follower->id,
                'firstname' => $follower->follower->firstname,
                'lastname' => $follower->follower->lastname,
                'profileImg' => $follower->follower->profile != null ? getenv('APP_URL') . 'public/profileImages/' . $follower->follower->profile->profileImg : 'https://ui-avatars.com/api/?name=' . $follower->follower->firstname . '+' . $follower->follower->lastname,
                'major' => $follower->follower->major,
            ];
        }

        return $followers;
    }
}
