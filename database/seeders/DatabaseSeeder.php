<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * No scaffold `User::factory()` call here: it needs fakerphp/faker,
     * a dev-only dependency, and the production image is built with
     * `composer install --no-dev`. Only the demo user is seeded.
     */
    public function run(): void
    {
        $this->call(DemoSeeder::class);
    }
}
