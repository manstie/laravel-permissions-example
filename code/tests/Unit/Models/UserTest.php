<?php

namespace Tests\Feature\Models;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_auths_to_api(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->assertFalse($user->isAdmin());

        $this->actingAs($user, 'api');
        $this->assertTrue(Auth::guard('api')->check());
        $this->assertFalse(Auth::guard('admin')->check());
        $this->assertInstanceOf(User::class, Auth::user());
    }

    #[Test]
    public function it_can_be_assigned_a_role(): void
    {
        /** @var Company */
        $company = Company::factory()->create();
        setPermissionsTeamId($company->id);
        /** @var User */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $role = Role::getDefaultCompanyRole(Role::COMPANY_SUPER_ADMIN);

        // https://github.com/spatie/laravel-permission/issues/2725
        // $this->assertFalse($user->can('company.delete'));
        $this->assertFalse($user->hasRole($role));
        $user->assignRole($role);
        $this->assertTrue($user->hasRole($role));

        $this->assertTrue($role->hasPermissionTo('company.delete'));
        $this->assertTrue($user->can('company.delete'));
    }
}
