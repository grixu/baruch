<?php

namespace Domain\Auth\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserGroup extends Pivot
{
    protected $table = 'user_group';
    public $timestamps = true;
}
