<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('serves the login screen', function (): void {
    $this->get('/login')->assertOk()->assertSee('lyra-btn', escape: false);
});

it('signs a user in with valid credentials', function (): void {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    $this->post('/login', ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid credentials', function (): void {
    User::factory()->create(['email' => 'demo@example.com', 'password' => bcrypt('password')]);

    $this->post('/login', ['email' => 'demo@example.com', 'password' => 'wrong'])
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('registers a new user', function (): void {
    $this->post('/register', [
        'name' => 'Ana',
        'email' => 'ana@example.com',
        'password' => 'password-longa',
        'password_confirmation' => 'password-longa',
    ])->assertRedirect('/dashboard');

    $this->assertDatabaseHas('users', ['email' => 'ana@example.com']);
});
