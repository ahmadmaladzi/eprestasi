<?php

namespace App\Notifications;

use App\Models\Prestasi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatusVerifikasiNotification extends Notification
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
            'status' => $this->prestasi->status,
            'catatan' => $this->prestasi->catatan,
            'pesan' => $this->prestasi->status === 'Disetujui'
                ? "Prestasi \"{$this->prestasi->nama_prestasi}\" kamu telah disetujui."
                : "Prestasi \"{$this->prestasi->nama_prestasi}\" kamu ditolak/perlu revisi.",
        ];
    }
}
