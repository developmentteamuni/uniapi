<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'hoster_id',
        'event_title',
        'location',
        'date',
        'time',
        'description',
        'ticket_count',
        'available',
        'recommended_donation_box',
        'ticket_price',
        'image',
        'user_id',
        'qr_codes'
    ];

    protected $casts = [
        'user_id' => 'json',
    ];

    public function images()
    {
        return $this->hasMany(EventImages::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
