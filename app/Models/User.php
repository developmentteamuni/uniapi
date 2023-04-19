<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'university',
        'major',
        'otp',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function followers()
    {
        return $this->hasMany(Friend::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function groupposts(): HasMany
    {
        return $this->hasMany(GroupPost::class);
    }

    public function getFullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function minors()
    {
        return $this->hasMany(Minor::class);
    }

    public function hobbies()
    {
        return $this->hasMany(Hobby::class);
    }

    public function interests()
    {
        return $this->hasMany(Interest::class);
    }
}
