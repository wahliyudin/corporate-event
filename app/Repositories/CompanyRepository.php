<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function dataSelect()
    {
        return Company::query()->select('id', 'name')->get();
    }
}
