<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Proposal;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel
        DB::table('proposals')->truncate();

        // Aktifkan kembali pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Cari mahasiswa
        $mahasiswa = User::where('role', 'mahasiswa')->first();

        // Tambah proposal contoh
        Proposal::create([
            'user_id' => $mahasiswa->id,
            'judul' => 'Sistem Informasi Manajemen Tugas Akhir',
            'deskripsi' => 'Proposal penelitian tentang sistem informasi untuk manajemen tugas akhir mahasiswa',
            'status' => 'diajukan',
            'tanggal_pengajuan' => now()
        ]);
    }
}