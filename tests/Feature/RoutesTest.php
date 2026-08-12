<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

dataset('product routes', ['/dashboard', '/schedule', '/files', '/team', '/settings']);

it('requires authentication', function (string $route): void {
    $this->get($route)->assertRedirect('/login');
})->with('product routes');

it('renders for a signed-in user', function (string $route): void {
    $this->actingAs(User::factory()->create())
        ->get($route)
        ->assertOk()
        ->assertSee('lyra-', escape: false);
})->with('product routes');
