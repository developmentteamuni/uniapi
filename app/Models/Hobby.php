<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hobby'
    ];

    public function user()
    {
        return $this->belongsTo(Hobby::class);
    }
}
