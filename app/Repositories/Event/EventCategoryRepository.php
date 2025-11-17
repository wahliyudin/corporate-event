<?php

namespace App\Repositories\Event;

use App\Data\Event\EventCategoryData;
use App\Models\EventCategory;

class EventCategoryRepository
{
    public function dataSelect()
    {
        return EventCategory::query()->select(['id', 'name', 'color'])->get();
    }

    public function dataForDatatable()
    {
        return EventCategory::query()
            ->select(['id', 'name', 'color'])
            ->addCanUpdateAndCanDelete('event_category')
            ->get();
    }

    public function checkUnique($name, $id)
    {
        return EventCategory::query()->where('name', $name)
            ->where('id', '!=', $id)->exists();
    }

    public function updateOrCreate(EventCategoryData $data)
    {
        $data = EventCategory::query()->updateOrCreate([
            'id' => $data->id
        ], $data->getDataForStore());
        return $data;
    }

    public function findOrFail($key)
    {
        return EventCategory::query()->findOrFail($key);
    }

    public function delete($key)
    {
        $data = $this->findOrFail($key);
        return $data->delete();
    }
}
