<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param string $permission
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next, string $permission): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    {
        abort_if(!$this->check($request, $permission), Response::HTTP_FORBIDDEN, 'Forbidden');
        return $next($request);
    }

    private function check(Request $request, string $permission): bool
    {
        $auth = $request->user();
        return $auth->hasRole(config('permission.role-super-admin')) ||
            in_array($permission, $auth->getAllPermissions()->pluck('name')->toArray(), true);
    }
}
