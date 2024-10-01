<?php

namespace Tests;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\Users\Admin;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function createAdmin($data = []): Admin
    {
        /** @var User */
        $user = User::factory()->create($data);
        $user->companies()->attach(Company::ADMIN_ID);
        setPermissionsTeamId(Company::ADMIN_ID);

        /** @var Admin */
        $admin = Admin::findOrFail($user->id);
        return $admin;
    }

    /**
     * Authenticate as an admin user with no restrictions
     */
    public function actingAsSuperAdmin()
    {
        $user = $this->createAdmin();
        $user->assignRole(Role::getDefaultAdminRole(Role::SUPER_ADMIN));
        $this->actingAs($user, 'admin');
        return $user;
    }

    /**
     * Authenticate as an admin with specific permissions under the 'admin' guard.
     */
    public function actingAsAdmin($permissions = [])
    {
        $user = $this->createAdmin();
        if (empty($permissions)) {
            $user->assignRole(Role::getDefaultAdminRole(Role::ADMIN));
        } else {
            $user->assignRole($this->createRoleWithPermissions('admin', $permissions));
        }
        $this->actingAs($user, 'admin');
        return $user;
    }

    /**
     * Authenticate as a company user with all permissions under the 'api' guard.
     */
    public function actingAsCompanySuperAdmin()
    {
        /** @var Company */
        $company = Company::factory()->create();
        setPermissionsTeamId($company->id);
        /** @var User */
        $user = User::factory()->create();
        $user->companies()->attach($company->id);
        $user->assignRole(Role::getDefaultCompanyRole(Role::COMPANY_SUPER_ADMIN));
        $this->actingAs($user, 'api');
        return $user;
    }

    /**
     * Authenticate as a user with specific permissions under the 'api' guard.
     */
    public function actingAsCompanyUser($permissions = [])
    {
        /** @var Company */
        $company = Company::factory()->create();
        setPermissionsTeamId($company->id);
        /** @var User */
        $user = User::factory()->create();
        $user->companies()->attach($company->id);
        $user->assignRole($this->createRoleWithPermissions('api', $permissions));
        $this->actingAs($user, 'api');
        return $user;
    }

    public function actingAsUser()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        return $user;
    }

    public function createRoleWithPermissions(string $guard, $permissions = []) 
    {
        /** @var Role */
        $role = Role::create([
            'name' => 'Test Role',
            'guard_name' => $guard,
        ]);
        $role->syncPermissions($permissions);
        return $role;
    }
}
