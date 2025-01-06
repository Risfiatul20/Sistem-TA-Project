<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemproPenilaian extends Model
{
    protected $table = 'sempro_penilaians';

    protected $fillable = [
        'sempro_id', 
        'aspek_penilaian', 
        'nilai'
    ];

    public function sempro()
    {
        return $this->belongsTo(Sempro::class);
    }
}