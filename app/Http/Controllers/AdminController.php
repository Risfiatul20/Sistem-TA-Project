<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_proposals' => \App\Models\Proposal::count(),
            'total_sempros' => \App\Models\Sempro::count()
        ];

        return view('admin.dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    }
}