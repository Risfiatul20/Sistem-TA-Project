<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Debugging log
            \Log::info('Login Berhasil', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);

            // Redirect berdasarkan role
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'kaprodi' => redirect()->route('kaprodi.dashboard'),
                'dosen' => redirect()->route('dosen.dashboard'),
                'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
                default => redirect()->intended(route('dashboard'))
            };
        } catch (\Exception $e) {
            // Logging error
            \Log::error('Login Gagal', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return back()->withErrors([
                'email' => 'Kredensial tidak valid.',
            ])->withInput();
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}