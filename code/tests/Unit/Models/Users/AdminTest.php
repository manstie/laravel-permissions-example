<?php

namespace Tests\Feature\Models;

use App\Models\Role;
use App\Models\Users\Admin;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_auths_to_admin_from_user_table(): void
    {
        $user = $this->createAdmin();
        $this->assertTrue($user->isAdmin());

        $this->actingAs($user, 'admin');
        $this->assertFalse(Auth::guard('api')->check());
        $this->assertTrue(Auth::guard('admin')->check());
        $this->assertInstanceOf(Admin::class, Auth::user());
    }

    #[Test]
    public function it_can_be_assigned_a_role(): void
    {
        $user = $this->createAdmin();
        $this->actingAs($user, 'admin');

        $role = Role::getDefaultAdminRole(Role::ADMIN);
        // https://github.com/spatie/laravel-permission/issues/2725
        // $this->assertFalse($user->can('company.view'));
        $this->assertFalse($user->hasRole($role));
        $user->assignRole($role);
        $this->assertTrue($user->hasRole($role));

        $this->assertTrue($role->hasPermissionTo('company.view'));
        $this->assertTrue($user->can('company.view'));
    }


    #[Test]
    public function it_lets_super_admins_do_everything(): void
    {
        $user = $this->createAdmin();
        $this->actingAs($user, 'admin');

        $role = Role::getDefaultAdminRole(Role::SUPER_ADMIN);

        $this->assertFalse($user->hasRole($role));
        $user->assignRole($role);
        $this->assertTrue($user->hasRole($role));
        /** @see code/app/Providers/AuthServiceProvider.php */
        $this->assertTrue($user->can('company.delete'));
        $this->assertTrue($user->can('do something that doesnt exist yet'));
    }
}
