<?php

namespace Domain\Auth\QueryBuilders;

use Domain\Auth\Models\Invitation;
use Illuminate\Database\Eloquent\Builder;

class InvitationQueryBuilder extends Builder
{
    public function findByUuid(string $uuid): Invitation | null
    {
        return $this->where('uuid', $uuid)->first();
    }
}
