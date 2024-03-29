<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // protected $casts = [
    //     'minor' => 'json',
    //     'major' => 'json',
    //     'hobbies' => 'json',
    //     'interests' => 'json',
    // ];

    public function interests()
    {
        return $this->hasMany(Interest::class, 'user_id');
    }

    public function minors()
    {
        return $this->hasMany(Minor::class, 'user_id');
    }

    public function hobbies()
    {
        return $this->hasMany(Hobby::class, 'user_id');
    }
}
