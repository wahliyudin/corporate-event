<?php

namespace App\Data\Event;

use App\Models\EventCategory;

class EventCategoryData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $color,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            color: $data['color'] ?? null,
        );
    }

    public static function fromModel(EventCategory $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            color: $model->color,
        );
    }

    public function getDataForStore()
    {
        $this->name = trim($this->name);
        return [
            'name' => $this->name,
            'color' => $this->color,
        ];
    }
}
