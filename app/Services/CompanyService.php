<?php

namespace App\Services;

use App\Data\CompanyData;
use App\Repositories\CompanyRepository;
use Illuminate\Validation\ValidationException;

class CompanyService
{
    public function __construct(
        public CompanyRepository $repository
    ) {}

    public function datatable()
    {
        return $this->repository->dataForDatatable();
    }

    public function store(array $data)
    {
        $data = CompanyData::fromArray($data);
        if ($this->repository->checkUnique($data->name, $data->id)) {
            throw ValidationException::withMessages([
                'name' => 'The company name has already been taken.',
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
                'name' => 'Company is used, can\'t update',
            ]);
        }
        return CompanyData::fromModel($model);
    }

    public function delete($key)
    {
        $model = $this->repository->findOrFail($key);
        if ($model->hasUsed()) {
            throw ValidationException::withMessages([
                'name' => 'Company is used, can\'t delete',
            ]);
        }
        return $model->delete();
    }
}
