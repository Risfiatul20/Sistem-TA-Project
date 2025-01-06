<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'user_id', 
        'judul', 
        'deskripsi', 
        'status',
        'tanggal_pengajuan'
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan sempro
    public function sempros()
    {
        return $this->hasMany(Sempro::class);
    }
}