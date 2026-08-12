<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

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

it('sends a user with confirmed 2FA to the two-factor challenge', function (): void {
    // Mirrors how Fortify's EnableTwoFactorAuthentication stores the columns:
    // encrypted secret and an encrypted JSON array of recovery codes.
    $user = User::factory()->create([
        'password' => bcrypt('password'),
        'two_factor_secret' => encrypt('JBSWY3DPEHPK3PXP'),
        'two_factor_recovery_codes' => encrypt(json_encode(['abcde12345-fghij67890'])),
        'two_factor_confirmed_at' => now(),
    ]);

    $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

    expect($response->headers->get('Location'))->toContain('two-factor-challenge');
    $this->assertGuest();
});

it('signs a 2FA user in after a valid recovery code on the challenge', function (): void {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
        'two_factor_secret' => encrypt('JBSWY3DPEHPK3PXP'),
        'two_factor_recovery_codes' => encrypt(json_encode(['abcde12345-fghij67890', 'klmno12345-pqrst67890'])),
        'two_factor_confirmed_at' => now(),
    ]);

    $this->post('/login', ['email' => $user->email, 'password' => 'password']);

    // Valid credentials alone must not authenticate a 2FA user.
    $this->assertGuest();

    $this->post('/two-factor-challenge', ['recovery_code' => 'abcde12345-fghij67890'])
        ->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

it('does not register passkey routes (feature disabled without UI or trait)', function (): void {
    expect(Route::has('passkey.login'))->toBeFalse()
        ->and(Route::has('passkey.store'))->toBeFalse();

    $this->get('/passkeys/login/options')->assertNotFound();
});
