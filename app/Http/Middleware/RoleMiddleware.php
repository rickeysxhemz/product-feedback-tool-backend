<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $role, $guard = null)
    {
        $authGuard = Auth::guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $roles = is_array($role)
            ? $role
            : explode('|', $role);

        if (!$authGuard->user()->hasAnyRole($roles)) {
            return Response::json([
                'status_code' => 403,
                'message' => 'You have no access or roles are missing!',
            ]);
        }

        return $next($request);
    }
}
