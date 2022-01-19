<?php

namespace Tests\Unit\Auth;

use Domain\Auth\Actions\GenerateInvitationUrl;
use Domain\Auth\Models\Invitation;
use Illuminate\Support\Str;
use Tests\TestCase;

class GenerateInvitationUrlTest extends TestCase
{
    /** @test */
    public function it_generate_singed_url()
    {
        $invitation = Invitation::factory()
            ->forCongregation()
            ->forInvitedBy()
            ->create();

        $testObj = app(GenerateInvitationUrl::class);
        $singedUrl = $testObj->execute($invitation);

        $this->assertNotEmpty($singedUrl);
        $this->assertTrue(Str::contains($singedUrl, [config('app.url'), 'signature']));
    }
}
