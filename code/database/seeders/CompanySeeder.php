<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Company */
        $company = Company::factory()->create();

        setPermissionsTeamId($company->id);

        /** @var User */
        $super = User::factory()->create();

        $role = Role::getDefaultCompanyRole(Role::COMPANY_SUPER_ADMIN);
        $super->assignRole($role);

        $company->users()->attach($super->id);

        /** @var User */
        $admin = User::factory()->create();

        $role = Role::getDefaultCompanyRole(Role::COMPANY_ADMIN);
        $admin->assignRole($role);

        $company->users()->attach($admin->id);
    }
}
