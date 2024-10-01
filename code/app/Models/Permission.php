<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission as BasePermission;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
class Permission extends BasePermission
{
    protected $casts = [
        'id' => 'int',
    ];

    public static function getAdminPermission(string $name): Permission
    {
        return Permission::whereGuardName('admin')->whereName($name)->firstOrFail();
    }

    public static function getCompanyPermission(string $name): Permission
    {
        return Permission::whereGuardName('api')->whereName($name)->firstOrFail();
    }
}
