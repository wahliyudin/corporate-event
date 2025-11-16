<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];

    public function badge()
    {
        return "<span class='badge' style='background-color: " . $this->color . "'>" . $this->name . "</span>";
    }

    public function hasUsed()
    {
        return $this->hasMany(Event::class)
            ->exists();
    }
}
