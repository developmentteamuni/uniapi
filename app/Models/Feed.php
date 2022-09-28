<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Feed extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['reacted'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getReactedAttribute()
    {
        return (bool) $this->reactions()->where('feed_id', $this->id)->where('user_id', Auth::user()->id)->count();
    }
}
