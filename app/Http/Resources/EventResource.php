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
            'title' => $this->event_title,
            'date' => $this->date,
            'price' => $this->ticket_price,
            'description' => $this->description,
            'count' => $this->ticket_count,
            'image' => env('APP_URL') . 'public/eventImages/' . $this->image,
        ];
    }
}
