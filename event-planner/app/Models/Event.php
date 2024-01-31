<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'tickets',
        'performer_id',
        'location_id'
    ];

    public function performer()
    {
        return $this->belongsTo(Performer::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
