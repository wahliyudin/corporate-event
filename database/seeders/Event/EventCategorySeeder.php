<?php

namespace Database\Seeders\Event;

use App\Models\EventCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventCategory::query()->upsert($this->data(), 'id');
    }

    public function data()
    {
        return [
            [
                'name' => 'Corporate Branding',
                'color' => '#3A5892',
            ],
            [
                'name' => 'CSR & Community',
                'color' => '#23B7E5',
            ],
            [
                'name' => 'Internal Engagement',
                'color' => '#26BF94',
            ],
            [
                'name' => 'Business & Innovation',
                'color' => '#49B6F5',
            ],
            [
                'name' => 'Training & Leadership',
                'color' => '#F5B8F5',
            ],
            [
                'name' => 'Religious / Holiday',
                'color' => '#12C2C2',
            ],
        ];
    }
}
