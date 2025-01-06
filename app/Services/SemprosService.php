<?php
namespace App\Services;

use App\Models\Sempro;
use App\Models\Proposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SemprosService
{
    public function createSempro(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Validasi proposal sudah disetujui
            $proposal = Proposal::findOrFail($data['proposal_id']);
            if ($proposal->status !== 'disetujui') {
                throw new \Exception('Proposal belum disetujui');
            }

            $sempro = new Sempro();
            $sempro->fill($data);
            $sempro->status = 'dijadwalkan';
            $sempro->save();

            return $sempro;
        });
    }

    public function updateSempro(Sempro $sempro, array $data)
    {
        return DB::transaction(function () use ($sempro, $data) {
            $sempro->fill($data);
            $sempro->save();

            return $sempro;
        });
    }

    public function changeSemprosStatus(Sempro $sempro, string $status)
    {
        return DB::transaction(function () use ($sempro, $status) {
            $sempro->status = $status;
            $sempro->save();

            return $sempro;
        });
    }

    public function getSemprosByUser($user)
    {
        return Sempro::filterByUserRole($user)->get();
    }
}