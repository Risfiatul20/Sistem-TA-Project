<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Sempro;

class SemproPolicy
{
    public function view(User $user, Sempro $sempro)
    {
        // Kaprodi bisa lihat semua
        if ($user->role === 'kaprodi') {
            return true;
        }

        // Mahasiswa hanya bisa lihat sempro milik proposalnya
        if ($user->role === 'mahasiswa') {
            return $sempro->proposal->user_id === $user->id;
        }

        // Dosen pembimbing atau penguji
        return $sempro->dosen_pembimbing_id === $user->id ||
               $sempro->dosen_penguji_id === $user->id;
    }

    public function create(User $user)
    {
        // Hanya kaprodi dan dosen yang bisa buat sempro
        return in_array($user->role, ['kaprodi', 'dosen']);
    }

    public function update(User $user, Sempro $sempro)
    {
        // Hanya kaprodi dan status belum selesai
        return $user->role === 'kaprodi' && 
               !in_array($sempro->status, ['selesai']);
    }

    public function delete(User $user, Sempro $sempro)
    {
        // Hanya kaprodi bisa hapus