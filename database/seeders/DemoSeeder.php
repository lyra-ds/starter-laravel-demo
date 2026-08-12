<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Seed the public demo user.
     *
     * Credentials are intentionally public — this is a live showcase, not a
     * secured environment. See the README for the documented password.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Lyra Demo',
            'email' => 'demo@lyra-ds.dev',
            'password' => 'lyra-demo-2026',
        ]);
    }
}
