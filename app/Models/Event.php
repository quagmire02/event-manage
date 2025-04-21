<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'club_name',
        'event_date',
        'venue',
        'needs_stalls',
        'number_of_stalls',
        'registration_form_link',
        'status',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'needs_stalls' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
} 