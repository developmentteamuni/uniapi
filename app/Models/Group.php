<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'group_type',
        'requirements',
        'link',
        'entrace',
        'describe',
        'description',
        'attendance',
        'fee',
        'user_id',
    ];

    public function groupImage(): HasMany
    {
        return $this->hasMany(GroupImage::class);
    }

    public function groupPosts(): HasMany
    {
        return $this->hasMany(GroupPost::class);
    }
}
