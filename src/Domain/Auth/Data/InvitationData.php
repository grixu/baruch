<?php

namespace Domain\Auth\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;

class InvitationData extends Data
{
    public function __construct(
        #[Uuid]
        public string $congregationId,
        #[Uuid]
        public string $groupId,
        public string $name,
        #[Email]
        public string $email,
    ) {
    }
}
