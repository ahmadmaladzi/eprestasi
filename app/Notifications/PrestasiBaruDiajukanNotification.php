<?php

namespace App\Notifications;

use App\Models\Prestasi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PrestasiBaruDiajukanNotification extends Notification
{
    use Queueable;

    public function __construct(public Prestasi $prestasi)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'prestasi_id' => $this->prestasi->id_prestasi,
            'nama_prestasi' => $this->prestasi->nama_prestasi,
            'pesan' => $this->prestasi->siswa->nama . ' mengajukan prestasi baru: "' . $this->prestasi->nama_prestasi . '"',
        ];
    }
}