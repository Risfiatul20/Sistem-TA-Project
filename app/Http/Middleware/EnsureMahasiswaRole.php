<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class EnsureMahasiswaRole
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== UserRole::MAHASISWA) {
            return redirect()->route('dashboard.index')
                ->with('error', 'Akses hanya untuk mahasiswa');
        }

        return $next($request);
    }
}