<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\Users\Admin;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where(['email' => 'super@test.com'])->exists()) {
            $super = User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'super@test.com'
            ]);
            $super->companies()->attach(Company::ADMIN_ID);

            /** @var Admin */
            $super = Admin::whereEmail('super@test.com')->firstOrFail();
            setPermissionsTeamId(Company::ADMIN_ID);
            $super->assignRole(Role::getDefaultAdminRole(Role::SUPER_ADMIN));
        }
        if (!User::where(['email' => 'admin@test.com'])->exists()) {
            $admin = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@test.com'
            ]);
            $admin->companies()->attach(Company::ADMIN_ID);
            
            /** @var Admin */
            $admin = Admin::whereEmail('admin@test.com')->firstOrFail();
            setPermissionsTeamId(Company::ADMIN_ID);
            $admin->assignRole(Role::getDefaultAdminRole(Role::ADMIN));
        }
    }
}
