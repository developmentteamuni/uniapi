<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use Intervention\Image\ImageManagerStatic as Image;

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
            'fullname' => $this->user->firstname . ' ' . $this->user->lastname,
            'body' => $this->body,
            'image' => $this->image != null ? env('APP_URL') . 'public/feedImages/' . $this->image : null,
            'created_at' => $this->created_at,
            'reacted' => $this->reacted,
            'saved' => $this->saved,
            'profileImg' => $this->user->profile != null ? getenv('APP_URL') . 'public/profileImages/' . $this->user->profile->profileImg : 'https://ui-avatars.com/api/?name=' . $this->user->firstname . '+' . $this->user->lastname,
            'liked_by' => $this->likedby,
            'width' => $this->image != null ? getimagesize('public/feedImages/' . $this->image)[0] : null,
            'height' => $this->image != null ? getimagesize('public/feedImages/' . $this->image)[1] : null,
        ];
    }
}
