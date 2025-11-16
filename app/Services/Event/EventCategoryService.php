<?php

namespace App\Services\Event;

use App\Data\Event\EventCategoryData;
use App\Repositories\Event\EventCategoryRepository;
use Illuminate\Validation\ValidationException;

class EventCategoryService
{
    public function __construct(
        public EventCategoryRepository $repository
    ) {}

    public function datatable()
    {
        return $this->repository->dataForDatatable();
    }

    public function store(array $data)
    {
        $data = EventCategoryData::fromArray($data);
        if ($this->repository->checkUnique($data->name, $data->id)) {
            throw ValidationException::withMessages([
                'name' => 'The Event Category name has already been taken.',
            ]);
        }
        $model = $this->repository->updateOrCreate($data);
        return $model;
    }

    public function findForUpdate($key)
    {
        $model = $this->repository->findOrFail($key);
        if ($model->hasUsed()) {
            throw ValidationException::withMessages([
                'name' => 'Event Category is used, can\'t update',
            ]);
        }
        return EventCategoryData::fromModel($model);
    }

    public function delete($key)
    {
        $model = $this->repository->findOrFail($key);
        if ($model->hasUsed()) {
            throw ValidationException::withMessages([
                'name' => 'Event Category is used, can\'t delete',
            ]);
        }
        return $model->delete();
    }
}
