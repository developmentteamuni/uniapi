<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileController extends JsonResource
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
            'fullname' => $this->user->firstname . '+' . $this->user->lastname,
            'body' => $this->body,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'reacted' => $this->reacted,
            'saved' => $this->saved,
            'profileImg' => $this->user->profile->profileImg ?? 'https://ui-avatars.com/api/?name=' . $this->user->firstname . '+' . $this->user->lastname,
        ];
    }
}
