<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSuperAdminDomain
{
    public function handle(Request $request, Closure $next)
    {
        // Cek domain
        if ($request->getHost() === 'admin.rumahsakit.test' || $request->getHost() === 'admin.rumahsakit.test:8000') {
            // Hanya boleh super admin
            if (!Auth::check() || !Auth::user()->hasRole('super_admin')) {
                return redirect()->route('logout');
            }
        }
        return $next($request);
    }
} 