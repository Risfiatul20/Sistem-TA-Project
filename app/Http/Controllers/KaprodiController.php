<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KaprodiController extends Controller
{
    public function dashboard()
    {
        try {
            $user = Auth::user();
            
            // Pastikan hanya kaprodi yang bisa akses
            if ($user->role !== 'kaprodi') {
                Log::warning('Percobaan akses dashboard kaprodi oleh non-kaprodi', [
                    'user_id' => $user->id,
                    'user_role' => $user->role
                ]);
                
                return redirect()->route('dashboard')
                    ->with('error', 'Anda tidak memiliki izin');
            }

            // Contoh statistik
            $stats = [
                'total_mahasiswa' => \App\Models\User::where('role', 'mahasiswa')->count(),
                'total_dosen' => \App\Models\User::where('role', 'dosen')->count(),
                'total_proposal' => \App\Models\Proposal::count() // Pastikan model ada
            ];

            return view('kaprodi.dashboard', [
                'user' => $user,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error di dashboard kaprodi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}