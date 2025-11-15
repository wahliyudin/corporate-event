<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::query()->upsert($this->data(), 'id');
    }

    public function data()
    {
        return [
            [
                'name' => 'Holding',
            ],
            [
                'name' => 'Subsidiary A'
            ],
            [
                'name' => 'Subsidiary B'
            ],
            [
                'name' => 'Subsidiary C'
            ],
            [
                'name' => 'Subsidiary D'
            ],
        ];
    }
}
