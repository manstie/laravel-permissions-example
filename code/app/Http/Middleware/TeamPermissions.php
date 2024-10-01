<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null */
        $user = $request->user();
        if ($user) {
            $companyId = session('company_id') ?? $user->companies()->firstOrFail()->id;
            setPermissionsTeamId($companyId);
        }

        return $next($request);
    }
}
