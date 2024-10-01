<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if (!$user->can('company.view')) {
            return Response::deny('You do not have permission to view companies.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): Response
    {
        if (!$user->canActionCompany($company)) {
            return Response::denyAsNotFound();
        }
        if (!$user->can('company.view')) {
            return Response::deny('You do not have permission to view companies.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if (!$user->can('company.create')) {
            return Response::deny('You do not have permission to create companies.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Company $company): Response
    {
        if (!$user->canActionCompany($company)) {
            return Response::denyAsNotFound();
        }
        if (!$user->can('company.update')) {
            return Response::deny('You do not have permission to update companies.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Company $company): Response
    {
        if (!$user->canActionCompany($company)) {
            return Response::denyAsNotFound();
        }
        if (!$user->can('company.delete')) {
            return Response::deny('You do not have permission to delete companies.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Company $company): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Company $company): bool
    {
        return false;
    }
}
