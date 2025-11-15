<?php

namespace App\Repositories;

use App\Data\CompanyData;
use App\Models\Company;

class CompanyRepository
{
    public function dataForDatatable()
    {
        return Company::query()
            ->select(['id', 'name'])
            ->get();
    }

    public function checkUnique($name, $id)
    {
        return Company::query()->where('name', $name)
            ->where('id', '!=', $id)->exists();
    }

    public function dataSelect()
    {
        return Company::query()->select('id', 'name')->get();
    }

    public function updateOrCreate(CompanyData $data)
    {
        $data = Company::query()->updateOrCreate([
            'id' => $data->id
        ], $data->getDataForStore());
        return $data;
    }

    public function findOrFail($key)
    {
        return Company::query()->findOrFail($key);
    }

    public function delete($key)
    {
        $data = $this->findOrFail($key);
        return $data->delete();
    }
}
