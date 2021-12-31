<?php

namespace Domain\Auth\Models;

use Domain\Auth\Factories\CongregationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @method \Domain\Auth\Models\Congregation make(array $attributes = [])
 * @method \Domain\Auth\Models\Congregation create(array $attributes = [])
 * @method \Domain\Auth\Models\Congregation forceCreate(array $attributes)
 * @method \Domain\Auth\Models\Congregation firstOrNew(array $attributes = [], array $values = [])
 * @method \Domain\Auth\Models\Congregation firstOrFail($columns = ['*'])
 * @method \Domain\Auth\Models\Congregation firstOrCreate(array $attributes, array $values = [])
 * @method \Domain\Auth\Models\Congregation firstOr($columns = ['*'], \Closure $callback = null)
 * @method \Domain\Auth\Models\Congregation firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method \Domain\Auth\Models\Congregation updateOrCreate(array $attributes, array $values = [])
 * @method \Domain\Auth\Models\Congregation findOrFail($id, $columns = ['*'])
 * @method \Domain\Auth\Models\Congregation findOrNew($id, $columns = ['*'])
 * @method null|\Domain\Auth\Models\Congregation first($columns = ['*'])
 * @method null|\Domain\Auth\Models\Congregation find($id, $columns = ['*'])
 *
 * @property string $uuid
 *
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 */
class Congregation extends Model
{
    use HasFactory;
    use HasSlug;

    public function groups(): HasMany
    {
        return $this->hasMany(
            Group::class,
            'congregation_id',
            'id'
        );
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(
            Invitation::class,
            'congregation_id',
            'id'
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(
            User::class,
            'congregation_id',
            'id'
        );
    }

    public static function newFactory(): CongregationFactory
    {
        return CongregationFactory::new();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
