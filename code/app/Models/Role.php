<?php

namespace App\Models;

use Spatie\Permission\Models\Role as BaseRole;

/**
 * App\Models\Role
 */
class Role extends BaseRole
{
    // Default role names under the 'admin' guard
    const SUPER_ADMIN = 'Super Admin';
    const ADMIN = 'Admin';

    // Default role names under the 'api' guard
    const COMPANY_SUPER_ADMIN = 'Super Administrator';
    const COMPANY_ADMIN = 'Administrator';

    public static function getDefaultAdminRole(string $name): Role
    {
        return Role::whereGuardName('admin')->whereName($name)->firstOrFail();
    }

    public static function getDefaultCompanyRole(string $name): Role
    {
        return Role::whereGuardName('api')->whereName($name)->firstOrFail();
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }
}
