<?php

namespace Domain\Auth\Models;

use Domain\Auth\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @method \Domain\Auth\Models\User make(array $attributes = [])
 * @method \Domain\Auth\Models\User create(array $attributes = [])
 * @method \Domain\Auth\Models\User forceCreate(array $attributes)
 * @method \Domain\Auth\Models\User firstOrNew(array $attributes = [], array $values = [])
 * @method \Domain\Auth\Models\User firstOrFail($columns = ['*'])
 * @method \Domain\Auth\Models\User firstOrCreate(array $attributes, array $values = [])
 * @method \Domain\Auth\Models\User firstOr($columns = ['*'], \Closure $callback = null)
 * @method \Domain\Auth\Models\User firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method \Domain\Auth\Models\User updateOrCreate(array $attributes, array $values = [])
 * @method \Domain\Auth\Models\User findOrFail($id, $columns = ['*'])
 * @method \Domain\Auth\Models\User findOrNew($id, $columns = ['*'])
 * @method null|\Domain\Auth\Models\User first($columns = ['*'])
 * @method null|\Domain\Auth\Models\User find($id, $columns = ['*'])
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 *
 * @property-read \Illuminate\Support\Carbon $email_verified_at
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
