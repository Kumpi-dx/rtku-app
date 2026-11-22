<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWarga
{
    /**
     * Batasi akses portal hanya untuk akun warga yang tertaut data kewargaan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user?->isWarga()) {
            return redirect()->route('dashboard');
        }

        if (! $user->warga()->exists() && ! $request->routeIs('portal.lengkapi', 'portal.lengkapi.store')) {
            return redirect()->route('portal.lengkapi');
        }

        return $next($request);
    }
}
