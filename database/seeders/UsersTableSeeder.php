<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin Sistem',
                'email' => 'admin@sistemta.test',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN
            ],
            [
                'name' => 'Koordinator Prodi',
                'email' => 'kaprodi@sistemta.test',
                'password' => Hash::make('password'),
                'role' => UserRole::KAPRODI
            ],
            [
                'name' => 'Dosen Pembimbing',
                'email' => 'dosen@sistemta.test',
                'password' => Hash::make('password'),
                'role' => UserRole::DOSEN,
                'nidn' => '1234567890'
            ],
            [
                'name' => 'Mahasiswa',
                'email' => 'mahasiswa@sistemta.test',
                'password' => Hash::make('password'),
                'role' => UserRole::MAHASISWA,
                'nim' => 'M0520001'
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}