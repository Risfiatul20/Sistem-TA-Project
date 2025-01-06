<?php
namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleService
{
    /**
     * Cek apakah user memiliki role tertentu
     *
     * @param string $role
     * @param User|null $user
     * @return bool
     */
    public function hasRole(string $role, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return false;
        }

        return $user->role === $role;
    }

    /**
     * Cek apakah user memiliki salah satu role
     *
     * @param array $roles
     * @param User|null $user
     * @return bool
     */
    public function hasAnyRole(array $roles, ?User $user = null): bool
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return false;
        }

        return in_array($user->role, $roles);
    }

    /**
     * Dapatkan role user saat ini
     *
     * @return string|null
     */
    public function getCurrentUserRole(): ?string
    {
        return Auth::user()?->role;
    }
}