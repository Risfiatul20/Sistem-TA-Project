<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_proposals' => \App\Models\Proposal::where('user_id', $user->id)->count(),
            'proposals_diajukan' => \App\Models\Proposal::where('user_id', $user->id)
                ->where('status', 'diajukan')->count()
        ];

        return view('mahasiswa.dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    }
}