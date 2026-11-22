<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePengurus
{
    /**
     * Cegah akun warga mengakses modul administrasi pengurus.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isPengurus()) {
            return redirect()->route('portal.index');
        }

        return $next($request);
    }
}
