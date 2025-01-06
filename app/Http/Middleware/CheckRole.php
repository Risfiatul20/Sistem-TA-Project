<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Logging untuk debugging
        \Log::info('Role Check', [
            'current_user' => Auth::check() ? Auth::user()->toArray() : 'Not Authenticated',
            'required_roles' => $roles
        ]);

        // Cek autentikasi
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();

        // Cek role
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Log pesan error
        \Log::warning('Akses Ditolak', [
            'user_role' => $user->role,
            'required_roles' => $roles
        ]);

        // Redirect dengan pesan error
        return redirect()->route('dashboard')
            ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini');
    }
}