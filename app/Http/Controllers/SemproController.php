<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/SemproController.php
class SemproController extends Controller
{
    public function create(Proposal $proposal)
    {
        // Tampilkan form pengajuan sempro
        return view('mahasiswa.sempro.create', compact('proposal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proposal_id' => 'required|exists:proposals,id',
            'dosen_pembimbing_id' => 'nullable|exists:users,id',
            'catatan' => 'nullable|string'
        ]);

        $sempro = Sempro::create([
            'proposal_id' => $validated['proposal_id'],
            'dosen_pembimbing_id' => $validated['dosen_pembimbing_id'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'menunggu'
        ]);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Pengajuan Sempro Berhasil');
    }

    public function jadwalkan(Request $request, Sempro $sempro)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'ruang' => 'required|string',
            'dosen_penguji_id' => 'required|exists:users,id'
        ]);

        $sempro->update([
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'ruang' => $validated['ruang'],
            'dosen_penguji_id' => $validated['dosen_penguji_id'],
            'status' => 'dijadwalkan'
        ]);

        return redirect()->back()->with('success', 'Sempro Dijadwalkan');
    }
}
