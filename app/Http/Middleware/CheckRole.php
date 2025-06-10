<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) return redirect('login');

        $user = Auth::user();

        logger($user); // log isi user
        logger($user->role); // log isi relasi role

        if (!$user->role) {
            abort(403, 'Role not found');
        }

        $userRole = $user->role->role_nama ?? 'no-role';

        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized: role = ' . $userRole);
        }

        return $next($request);
    }
}
