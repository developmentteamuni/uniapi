<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResources extends JsonResource
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
            'feed_id' => $this->feed_id,
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'profile_img' => $this->user->profile->profileImg ?? 'https://ui-avatars.com/api/?name=' . $this->user->firstname . '+' . $this->user->lastname
        ];
    }
}
