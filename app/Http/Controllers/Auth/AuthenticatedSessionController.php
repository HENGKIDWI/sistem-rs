<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = $request->user();

        if ($user->hasRole('super_admin')) {
            return redirect()->intended('http://admin.rumahsakit.test:8000'); // Sesuaikan dengan URL super admin
        } elseif ($user->hasRole('admin_rs')) {
            return redirect()->intended(route('admin.rs.dashboard')); // Ganti dengan nama rute yang benar
        } elseif ($user->hasRole('dokter')) {
            return redirect()->intended(route('dokter.dashboard')); // Ganti dengan nama rute yang benar
        }

        return redirect()->intended(route('dashboard')); // Fallback untuk pasien
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
