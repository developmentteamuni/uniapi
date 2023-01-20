<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'joiner_id',
        'group_owner',
    ];
}
