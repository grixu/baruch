<?php

namespace Domain\Auth\Data;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(public string $id) {}
}
