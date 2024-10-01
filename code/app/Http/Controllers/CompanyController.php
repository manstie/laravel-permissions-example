<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Company::class);

        /** @var \App\Models\User */
        $user = $request->user();
        if ($user->isAdmin()) {
            return response()->json(Company::where('company_id', null)->get());
        } else {
            return response()->json(Company::where('company_id', getPermissionsTeamId())->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        Gate::authorize('create', Company::class);

        $company = new Company();
        $company->fill($request->validated());
        $company->save();

        return response()->json($company);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        Gate::authorize('view', $company);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, Company $company)
    {
        Gate::authorize('update', $company);

        $company->fill($request->validated());
        $company->save();

        return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        Gate::authorize('delete', $company);

        if ($company->id !== Company::ADMIN_ID) {
            $company->delete();
        } else {
            abort(403, 'You cannot delete Admin');
        }
    }
}
