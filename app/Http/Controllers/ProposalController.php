<?php
namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Logika berbeda berdasarkan role
        switch($user->role) {
            case 'mahasiswa':
                $proposals = Proposal::where('user_id', $user->id)->get();
                return view('mahasiswa.proposal.index', compact('proposals'));
            
            case 'dosen':
                // Proposal yang terkait dengan dosen
                $proposals = Proposal::all();
                return view('dosen.proposal.index', compact('proposals'));
            
            case 'kaprodi':
                $proposals = Proposal::all();
                return view('kaprodi.proposal.index', compact('proposals'));
            
            default:
                return redirect()->back()->with('error', 'Akses ditolak');
        }
    }

    public function create()
    {
        // Hanya mahasiswa yang bisa membuat proposal
        if (Auth::user()->role !== 'mahasiswa') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        return view('mahasiswa.proposal.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'nullable|max:1000'
        ]);

        // Buat proposal baru
        $proposal = new Proposal();
        $proposal->user_id = Auth::id();
        $proposal->judul = $validatedData['judul'];
        $proposal->deskripsi = $validatedData['deskripsi'];
        $proposal->status = 'draft';
        $proposal->tanggal_pengajuan = now();
        $proposal->save();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil dibuat');
    }

    public function show(Proposal $proposal)
    {
        // Cek otorisasi
        $user = Auth::user();
        
        // Mahasiswa hanya bisa lihat proposal sendiri
        if ($user->role == 'mahasiswa' && $proposal->user_id != $user->id) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        return view('proposal.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        // Hanya mahasiswa pemilik proposal yang bisa edit
        if (Auth::id() !== $proposal->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        // Hanya proposal dengan status draft yang bisa diedit
        if ($proposal->status !== 'draft') {
            return redirect()->back()->with('error', 'Proposal tidak bisa diedit');
        }

        return view('mahasiswa.proposal.edit', compact('proposal'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'nullable|max:1000'
        ]);

        // Cek otorisasi
        if (Auth::id() !== $proposal->user_id) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        // Update proposal
        $proposal->judul = $validatedData['judul'];
        $proposal->deskripsi = $validatedData['deskripsi'];
        $proposal->save();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil diupdate');
    }

    public function destroy(Proposal $proposal)
    {
        // Hanya mahasiswa pemilik proposal yang bisa hapus
        if (Auth::id() !== $proposal->user_id) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        // Hanya proposal draft yang bisa dihapus
        if ($proposal->status !== 'draft') {
            return redirect()->back()->with('error', 'Proposal tidak bisa dihapus');
        }

        $proposal->delete();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil dihapus');
    }

    // Method khusus Kaprodi
    public function approve(Proposal $proposal)
    {
        $user = Auth::user();
        
        // Hanya Kaprodi yang bisa approve
        if ($user->role !== 'kaprodi') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $proposal->status = 'disetujui';
        $proposal->save();

        return redirect()->back()->with('success', 'Proposal disetujui');
    }

    public function reject(Proposal $proposal)
    {
        $user = Auth::user();
        
        // Hanya Kaprodi yang bisa reject
        if ($user->role !== 'kaprodi') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $proposal->status = 'ditolak';
        $proposal->save();

        return redirect()->back()->with('success', 'Proposal ditolak');
    }
}