<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Feed extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'image'];
    protected $appends = ['reacted', 'saved', 'likedby'];

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

    public function savefeeds()
    {
        return $this->hasMany(SavedFeed::class);
    }

    public function getReactedAttribute()
    {
        return (bool) $this->reactions()->where('feed_id', $this->id)->where('user_id', Auth::user()->id)->count();
    }

    public function getLikedByAttribute()
    {
        $first_liked = $this->reactions()->inRandomOrder()->limit(1)->pluck('user_id');
        return $this->reactions()->count() > 0 ? User::whereId($first_liked)->pluck('firstname')->first() . ' ' .  'and others' : '';
    }

    public function getSavedAttribute()
    {
        return (bool) $this->savefeeds()->where('feed_id', $this->id)->where('user_id', Auth::user()->id)->count();
    }
}
