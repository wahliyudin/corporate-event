<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Event\EventCategorySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
        //     CompanySeeder::class,
        //     EventCategorySeeder::class,
        // ]);
        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt(1234567890),
        ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
