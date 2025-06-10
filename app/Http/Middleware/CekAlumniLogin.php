<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekAlumniLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $alumni_id = $request->route('id'); // asumsi {id} di route

        $user = Auth::guard('alumni')->user(); // atau guard default jika alumni pakai default guard

        if (!$user || $user->alumni_id != $alumni_id) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
