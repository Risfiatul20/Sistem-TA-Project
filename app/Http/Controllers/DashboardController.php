<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Proposal;
use App\Models\Sempro;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Dashboard berbeda untuk setiap role
        switch($user->role) {
            case 'mahasiswa':
                return $this->mahasiswaDashboard($user);
            case 'dosen':
                return $this->dosenDashboard($user);
            case 'kaprodi':
                return $this->kaprodiDashboard($user);
            default:
                return redirect()->route('login');
        }
    }

    protected function mahasiswaDashboard($user)
    {
        // Proposal mahasiswa
        $proposals = Proposal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Sempro mahasiswa
        $sempros = Sempro::whereHas('proposal', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->orderBy('tanggal', 'desc')
        ->take(3)
        ->get();

        // Statistik
        $totalProposals = Proposal::where('user_id', $user->id)->count();
        $approvedProposals = Proposal::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->count();

        return view('dashboard.mahasiswa', [
            'proposals' => $proposals,
            'sempros' => $sempros,
            'totalProposals' => $totalProposals,
            'approvedProposals' => $approvedProposals
        ]);
    }

    protected function dosenDashboard($user)
    {
        // Proposal yang dibimbing/diuji
        $proposals = Proposal::whereHas('sempros', function($query) use ($user) {
            $query->where('dosen_pembimbing_id', $user->id)
                  ->orWhere('dosen_penguji_id', $user->id);
        })->orderBy('created_at', 'desc')
          ->take(5)
          ->get();

        // Sempro yang diampu
        $sempros = Sempro::where('dosen_pembimbing_id', $user->id)
            ->orWhere('dosen_penguji_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->take(3)
            ->get();

        // Statistik
        $totalBimbingan = Sempro::where('dosen_pembimbing_id', $user->id)->count();
        $totalPenguji = Sempro::where('dosen_penguji_id', $user->id)->count();

        return view('dashboard.dosen', [
            'proposals' => $proposals,
            'sempros' => $sempros,
            'totalBimbingan' => $totalBimbingan,
            'totalPenguji' => $totalPenguji
        ]);
    }

    protected function kaprodiDashboard($user)
    {
        // Statistik Proposal
        $proposalStats = [
            'total' => Proposal::count(),
            'draft' => Proposal::where('status', 'draft')->count(),
            'diajukan' => Proposal::where('status', 'diajukan')->count(),
            'disetujui' => Proposal::where('status', 'disetujui')->count(),
            'ditolak' => Proposal::where('status', 'ditolak')->count(),
        ];

        // Statistik Sempro
        $semproStats = [
            'total' => Sempro::count(),
            'dijadwalkan' => Sempro::where('status', 'dijadwalkan')->count(),
            'berlangsung' => Sempro::where('status', 'berlangsung')->count(),
            'selesai' => Sempro::where('status', 'selesai')->count(),
            'ditunda' => Sempro::where('status', 'ditunda')->count(),
        ];

        // Recent Activities
        $recentProposals = Proposal::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentSempros = Sempro::orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Mahasiswa dan Dosen
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalDosen = User::where('role', 'dosen')->count();

        return view('dashboard.kaprodi', [
            'proposalStats' => $proposalStats,
            'semproStats' => $semproStats,
            'recentProposals' => $recentProposals,
            'recentSempros' => $recentSempros,
            'totalMahasiswa' => $totalMahasiswa,
            'totalDosen' => $totalDosen
        ]);
    }

    // Metode untuk grafik dan statistik
    public function getProposalTrend()
    {
        $user = Auth::user();

        // Hanya kaprodi yang bisa akses
        if ($user->role !== 'kaprodi') {
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        }

        // Ambil trend proposal per bulan
        $proposalTrend = Proposal::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($proposalTrend);
    }

    // Metode untuk export laporan
    public function exportDashboardReport()
    {
        $user = Auth::user();

        // Hanya kaprodi yang bisa export
        if ($user->role !== 'kaprodi') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        // Generate laporan
        $data = $this->kaprodiDashboard($user);

        // Contoh export PDF
        $pdf = \PDF::loadView('reports.dashboard', $data);
        return $pdf->download('laporan-dashboard.pdf');
    }
}