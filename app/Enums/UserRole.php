<?php
namespace App\Enums;

class UserRole
{
    public const ADMIN = 'admin';
    public const KAPRODI = 'kaprodi';
    public const DOSEN = 'dosen';
    public const MAHASISWA = 'mahasiswa';

    public static function roles(): array
    {
        return [
            self::ADMIN,
            self::KAPRODI,
            self::DOSEN,
            self::MAHASISWA
        ];
    }
}