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

it('shows the security section with an enable 2FA control on /settings', function (): void {
    $this->actingAs(User::factory()->create())
        ->get('/settings')
        ->assertOk()
        ->assertSee('data-testid="security-2fa"', escape: false)
        ->assertSee('action="/user/two-factor-authentication"', escape: false)
        ->assertSee('Enable two-factor authentication');
});

it('shows the QR code and confirm form while 2FA is pending confirmation', function (): void {
    $user = User::factory()->create([
        'two_factor_secret' => encrypt('JBSWY3DPEHPK3PXP'),
        'two_factor_recovery_codes' => encrypt(json_encode(['abcde12345-fghij67890'])),
    ]);

    $this->actingAs($user)
        ->get('/settings')
        ->assertOk()
        ->assertSee('<svg', escape: false)
        ->assertSee('action="/user/confirmed-two-factor-authentication"', escape: false)
        ->assertSee('Confirmation code');
});

it('shows recovery codes and a disable control once 2FA is confirmed', function (): void {
    $user = User::factory()->create([
        'two_factor_secret' => encrypt('JBSWY3DPEHPK3PXP'),
        'two_factor_recovery_codes' => encrypt(json_encode(['abcde12345-fghij67890'])),
        'two_factor_confirmed_at' => now(),
    ]);

    $this->actingAs($user)
        ->get('/settings')
        ->assertOk()
        ->assertSee('abcde12345-fghij67890')
        ->assertSee('Disable two-factor authentication');
});
