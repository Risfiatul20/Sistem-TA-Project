<?php
namespace App\Services;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProposalService
{
    public function createProposal(array $data)
    {
        return DB::transaction(function () use ($data) {
            $proposal = new Proposal();
            $proposal->user_id = Auth::id();
            $proposal->judul = $data['judul'];
            $proposal->deskripsi = $data['deskripsi'] ?? null;
            $proposal->status = 'draft';
            $proposal->tanggal_pengajuan = now();
            $proposal->save();

            return $proposal;
        });
    }

    public function updateProposal(Proposal $proposal, array $data)
    {
        return DB::transaction(function () use ($proposal, $data) {
            $proposal->judul = $data['judul'];
            $proposal->deskripsi = $data['deskripsi'] ?? null;
            $proposal->save();

            return $proposal;
        });
    }

    public function changeProposalStatus(Proposal $proposal, string $status)
    {
        return DB::transaction(function () use ($proposal, $status) {
            $proposal->status = $status;
            $proposal->save();

            return $proposal;
        });
    }

    public function getProposalsForUser(User $user)
    {
        return match($user->role) {
            'mahasiswa' => Proposal::where('user_id', $user->id)->get(),
            'dosen' => Proposal::all(), // Bisa disesuaikan
            'kaprodi' => Proposal::all(),
            default => collect([])
        };
    }
}