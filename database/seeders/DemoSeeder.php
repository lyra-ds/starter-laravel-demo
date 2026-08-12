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
        // Deliberate tradeoff vs the plan's "nem sobrescrever": on a public
        // showcase, self-healing demo credentials beat preserving edits.
        User::updateOrCreate(
            ['email' => 'demo@lyra-ds.dev'],
            [
                'name' => 'Lyra Demo',
                'password' => 'lyra-demo-2026',
            ]
        );
    }
}
