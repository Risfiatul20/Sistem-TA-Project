<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Sempro;

class SemproScheduledNotification extends Notification
{
    use Queueable;

    protected $sempro;

    public function __construct(Sempro $sempro)
    {
        $this->sempro = $sempro;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Jadwal Seminar Proposal')
            ->line('Jadwal seminar proposal telah ditentukan.')
            ->line('Judul: ' . $this->sempro->proposal->judul)
            ->line('Tanggal: ' . $this->sempro->tanggal->format('d M Y'))
            ->line('Jam: ' . $this->sempro->jam)
            ->line('Ruang: ' . $this->sempro->ruang);
    }

    public function toDatabase($notifiable)
    {
        return [
            'sempro_id' => $this->sempro->id,
            'proposal_id' => $this->sempro->proposal_id,
            'message' => 'Jadwal seminar proposal telah ditentukan',
            'tanggal' => $this->sempro->tanggal,
            'jam' => $this->sempro->jam,
        ];
    }
}
