<?php

namespace Domain\Auth\Models;

use Domain\Auth\Factories\InvitationFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @method \Domain\Auth\Models\Invitation make(array $attributes = [])
 * @method \Domain\Auth\Models\Invitation create(array $attributes = [])
 * @method \Domain\Auth\Models\Invitation forceCreate(array $attributes)
 * @method \Domain\Auth\Models\Invitation firstOrNew(array $attributes = [], array $values = [])
 * @method \Domain\Auth\Models\Invitation firstOrFail($columns = ['*'])
 * @method \Domain\Auth\Models\Invitation firstOrCreate(array $attributes, array $values = [])
 * @method \Domain\Auth\Models\Invitation firstOr($columns = ['*'], \Closure $callback = null)
 * @method \Domain\Auth\Models\Invitation firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method \Domain\Auth\Models\Invitation updateOrCreate(array $attributes, array $values = [])
 * @method \Domain\Auth\Models\Invitation findOrFail($id, $columns = ['*'])
 * @method \Domain\Auth\Models\Invitation findOrNew($id, $columns = ['*'])
 * @method null|\Domain\Auth\Models\Invitation first($columns = ['*'])
 * @method null|\Domain\Auth\Models\Invitation find($id, $columns = ['*'])
 *
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property int $congregation_id
 * @property int $group_id
 *
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 */
class Invitation extends Model
{
    use HasFactory;
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'congregation_id',
        'group_id',
    ];

    public function congregation(): BelongsTo
    {
        return $this->belongsTo(
            Congregation::class,
            'congregation_id',
            'id'
        );
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(
            Group::class,
            'group_id',
            'id'
        );
    }

    public static function newFactory(): InvitationFactory
    {
        return InvitationFactory::new();
    }
}
