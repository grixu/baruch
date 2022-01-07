<?php

namespace Domain\Auth\Data;

use Domain\Auth\Enums\GroupTypeEnum;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class GroupData extends Data
{
    public function __construct(
        public string $name,
        #[Enum(GroupTypeEnum::class)]
        public GroupTypeEnum $type,
        /** @var UserData[] */
        public DataCollection $users,
    )
    {}
}
