<?php

use Domain\Auth\Actions\GenerateInvitationUrl;
use Domain\Auth\Models\Invitation;

it("generate_singed_url", function () {
    $invitation = Invitation::factory()
        ->forCongregation()
        ->forInvitedBy()
        ->create();

    $testObj = app(GenerateInvitationUrl::class);
    $singedUrl = $testObj->execute($invitation);

    expect($singedUrl)->not()->toBeEmpty();
    expect($singedUrl)->toContain(config('app.url'), 'signature');
});
