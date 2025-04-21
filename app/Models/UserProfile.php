<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'current_semester',
        'department',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 