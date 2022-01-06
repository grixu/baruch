<?php

namespace Domain\Auth\Models;

use Domain\Auth\Enums\GroupTypeEnum;
use Domain\Auth\Factories\GroupFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @method \Domain\Auth\Models\Group make(array $attributes = [])
 * @method \Domain\Auth\Models\Group create(array $attributes = [])
 * @method \Domain\Auth\Models\Group forceCreate(array $attributes)
 * @method \Domain\Auth\Models\Group firstOrNew(array $attributes = [], array $values = [])
 * @method \Domain\Auth\Models\Group firstOrFail($columns = ['*'])
 * @method \Domain\Auth\Models\Group firstOrCreate(array $attributes, array $values = [])
 * @method \Domain\Auth\Models\Group firstOr($columns = ['*'], \Closure $callback = null)
 * @method \Domain\Auth\Models\Group firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method \Domain\Auth\Models\Group updateOrCreate(array $attributes, array $values = [])
 * @method \Domain\Auth\Models\Group findOrFail($id, $columns = ['*'])
 * @method \Domain\Auth\Models\Group findOrNew($id, $columns = ['*'])
 * @method null|\Domain\Auth\Models\Group first($columns = ['*'])
 * @method null|\Domain\Auth\Models\Group find($id, $columns = ['*'])
 *
 * @property string $uuid
 *
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * @property Collection<User> $users
 */
class Group extends Model
{
    use HasFactory;
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'type' => GroupTypeEnum::class,
    ];

    public function congregation(): BelongsTo
    {
        return $this->belongsTo(
            Congregation::class,
            'congregation_id',
            'id'
        );
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(
            Invitation::class,
            'group_id',
            'id'
        );
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_group',
            'group_id',
            'user_id'
        )->using(UserGroup::class);
    }

    public static function newFactory(): GroupFactory
    {
        return GroupFactory::new();
    }
}
