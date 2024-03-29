<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory;

    protected $fillable = [
        'interest',
        'user_id'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
