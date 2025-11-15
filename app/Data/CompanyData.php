<?php

namespace App\Data;

use App\Models\Company;

class CompanyData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
        );
    }

    public static function fromModel(Company $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
        );
    }

    public function getDataForStore()
    {
        $this->name = trim($this->name);
        return [
            'name' => $this->name,
        ];
    }
}
