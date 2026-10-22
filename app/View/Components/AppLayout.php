<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Judul halaman yang tampil di header. Kalau tidak diisi,
     * layout memakai "Dashboard" sebagai default.
     */
    public function __construct(public ?string $title = null)
    {
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
