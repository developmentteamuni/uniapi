<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roomate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'description',
        'clean',
        'sleep_schdeule',
        'noise_level',
        'lots_of_time_in_room',
        'company',
        'social',
        'study_location',
        'requirements',
        'campus',
        'time_to_campus',
        'sublease',
        'user_id',
    ];
}
