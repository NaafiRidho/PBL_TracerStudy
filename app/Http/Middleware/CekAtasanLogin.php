<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekAtasanLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $atasan_id = $request->route('id'); // ambil {id} dari route

        $user = Auth::guard('atasan')->user(); // ambil user dari guard atasan

        if (!$user || $user->atasan_id != $atasan_id) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
