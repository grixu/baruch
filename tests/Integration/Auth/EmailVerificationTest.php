<?php

use App\Providers\RouteServiceProvider;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    /* @var User $user */
    $this->user = User::factory()->create([
        'email_verified_at' => null,
    ]);
});

it("email_verification_screen_can_be_rendered", function () {
    actingAs($this->user)
        ->get('/verify-email')
        ->assertStatus(200);
});

it("email_can_be_verified", function () {
    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
    );

    $response = actingAs($this->user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($this->user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(RouteServiceProvider::HOME . '?verified=1');
});

it("email_is_not_verified_with_invalid_hash", function () {
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1('wrong-email')]
    );

    actingAs($this->user)->get($verificationUrl);

    expect($this->user->fresh()->hasVerifiedEmail())->toBeFalse();
});
