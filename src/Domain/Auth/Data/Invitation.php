<?php

namespace Domain\Auth\Data;

use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;

class Invitation extends Data
{
    public function __construct(
        public int $congregationId,
        #[Uuid]
        public string $groupId,
        public string $name,
        #[Email]
        public string $email,
        #[Nullable,Uuid]
        public string|null $invitedBy,
    ) {
    }

    public function all(): array
    {
        $this->assertInvitationIssuer();
        return parent::all();
    }

    private function assertInvitationIssuer(): void
    {
        if ($this->isInvitationIssuerEmpty()) {
            $this->invitedBy = Auth::id();
        }
    }

    private function isInvitationIssuerEmpty(): bool
    {
        return $this->invitedBy === null;
    }
}
