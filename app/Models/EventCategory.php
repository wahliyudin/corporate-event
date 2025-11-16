<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];

    public function hasUsed()
    {
        return $this->hasMany(Event::class)
            ->exists();
    }
}
