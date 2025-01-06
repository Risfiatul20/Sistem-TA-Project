<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel
        DB::table('users')->truncate();

        // Aktifkan kembali pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tambah user
        User::insert([
            [
                'name' => 'Kepala Prodi',
                'email' => 'kaprodi@example.com',
                'password' => Hash::make('password123'),
                'role' => 'kaprodi',
                'nidn' => '1234567890',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mahasiswa Contoh',
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nim' => '2020001',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dosen Pembimbing',
                'email' => 'dosen@example.com',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'nidn' => '0987654321',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}