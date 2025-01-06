<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sempro extends Model
{
    protected $fillable = [
        'proposal_id',
        'dosen_pembimbing_id',
        'dosen_penguji_id',
        'tanggal',
        'jam',
        'ruang',
        'status',
        'catatan'
    ];

    // Relasi dengan proposal
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    // Relasi dengan dosen pembimbing
    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }

    // Relasi dengan dosen penguji
    public function dosenPenguji()
    {
        return $this->belongsTo(User::class, 'dosen_penguji_id');
    }
}