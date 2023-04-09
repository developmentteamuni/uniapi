<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'hoster_id' => $this->hoster_id,
            'title' => $this->event_title,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
            'price' => $this->ticket_price,
            'description' => $this->description,
            'count' => $this->ticket_count,
            'available' => $this->available ?? 0,
            'image' => EventImageResource::collection($this->images),
        ];
    }
}
