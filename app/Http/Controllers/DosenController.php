<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_bimbingan' => \App\Models\Sempro::where('dosen_pembimbing_id', $user->id)->count(),
            'total_penguji' => \App\Models\Sempro::where('dosen_penguji_id', $user->id)->count()
        ];

        return view('dosen.dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    }
}