<?php
namespace App\Services;

use App\Models\User;
use App\Models\Sempro;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SemproScheduledNotification;
use App\Notifications\SemproStatusChangedNotification;

class NotificationService
{
    public function notifySemproScheduled(Sempro $sempro)
    {
        // Kirim notifikasi ke mahasiswa, dosen pembimbing, dan dosen penguji
        $recipients = [
            $sempro->proposal->user,
            $sempro->dosenPembimbing,
            $sempro->dosenPenguji
        ];

        foreach ($recipients as $recipient) {
            $recipient->notify(new SemproScheduledNotification($sempro));
        }
    }

    public function notifySemproStatusChanged(Sempro $sempro, $oldStatus)
    {
        $recipients = [
            $sempro->proposal->user,
            $sempro->dosenPembimbing,
            $sempro->dosenPenguji
        ];

        foreach ($recipients as $recipient) {
            $recipient->notify(new SemproStatusChangedNotification(
                $sempro, 
                $oldStatus
            ));
        }
    }
}