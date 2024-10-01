<?php

namespace App\Models\Users;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;

/**
 * App\Models\Users\Admin
 */
class Admin extends User
{
    protected $table = 'users';

    public function isAdmin()
    {
        return true;
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_users', 'user_id')
            ->using(CompanyUser::class);
    }
}
