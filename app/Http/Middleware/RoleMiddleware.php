<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null) {
        if(!$request->user()->hasRole($role)) {
            abort(404); // abort if no role
        }
        if($permission !== null && !$request->user()->can($permission)) {
            abort(404); // abort if no permission
        }
        return $next($request);
    }
}
