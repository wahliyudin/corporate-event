<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];

    public function badge($name = null, $className = '')
    {
        return "<span class='badge {$className}' style='background-color: " . $this->color . "'>" . $name ?? $this->name . "</span>";
    }

    public function hasUsed()
    {
        return $this->hasMany(Event::class)
            ->exists();
    }
}
