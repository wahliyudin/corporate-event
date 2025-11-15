<?php

namespace App\Repositories\Event;

use App\Models\EventCategory;

class EventCategoryRepository
{
    public function dataSelect()
    {
        return EventCategory::query()->select(['id', 'name', 'color'])->get();
    }
}
