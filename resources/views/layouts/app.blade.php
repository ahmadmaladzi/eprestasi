<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} — E-Prestasi</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon-32.png') }}" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .scrollbar-slim::-webkit-scrollbar { width: 6px; }
        .scrollbar-slim::-webkit-scrollbar-thumb { background: rgba(11, 30, 56, .12); border-radius: 999px; }
        .scrollbar-slim::-webkit-scrollbar-track { background: transparent; }
    </style>
</head>
<body class="bg-[#F5F7FB] text-[#0B1E38] antialiased">
    @php
        $u = auth()->user();
        $roleLabel = match ($u?->role) {
            'admin' => 'Administrator',
            'kesiswaan' => 'Kesiswaan',
            default => 'Siswa',
        };
        $pageTitle = $title ?? 'Dashboard';

        if ($u?->isSiswa()) {
            $menuGroups = [
                ['label' => 'Utama', 'items' => [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('siswa.dashboard'), 'active' => request()->routeIs('siswa.dashboard')],
                ]],
                ['label' => 'Prestasi', 'items' => [
                    ['label' => 'Prestasi Saya', 'icon' => 'trophy', 'href' => route('siswa.prestasi.index'), 'active' => request()->routeIs('siswa.prestasi.*')],
                    ['label' => 'Portofolio', 'icon' => 'qr', 'href' => route('siswa.portofolio'), 'active' => false],
                ]],
                ['label' => 'Akun', 'items' => [
                    ['label' => 'Profil', 'icon' => 'user', 'href' => route('siswa.profil'), 'active' => request()->routeIs('siswa.profil')],
                ]],
            ];
        } elseif ($u?->isKesiswaan()) {
            $menuGroups = [
                ['label' => 'Utama', 'items' => [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('kesiswaan.dashboard'), 'active' => request()->routeIs('kesiswaan.dashboard')],
                ]],
                ['label' => 'Verifikasi', 'items' => [
                    ['label' => 'Verifikasi Prestasi', 'icon' => 'clipboard', 'href' => route('kesiswaan.prestasi.index'), 'active' => request()->routeIs('kesiswaan.prestasi.*')],
                ]],
                ['label' => 'Analisis', 'items' => [
                    ['label' => 'Statistik', 'icon' => 'chart', 'href' => route('kesiswaan.statistik'), 'active' => request()->routeIs('kesiswaan.statistik')],
                ]],
                ['label' => 'Akun', 'items' => [
                    ['label' => 'Profil', 'icon' => 'user', 'href' => route('kesiswaan.profil'), 'active' => request()->routeIs('kesiswaan.profil')],
                    ['label' => 'Ganti Password', 'icon' => 'lock', 'href' => route('akunpassword.edit'), 'active' => request()->routeIs('akunpassword.*')],
                ]],
            ];
        } else {
            $menuGroups = [
                ['label' => 'Utama', 'items' => [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
                ]],
                ['label' => 'Manajemen', 'items' => [
                    ['label' => 'Akun Pengguna', 'icon' => 'users', 'href' => route('admin.users.index'), 'active' => request()->routeIs('admin.users.*')],
                    ['label' => 'Kelas', 'icon' => 'school', 'href' => route('admin.kelas.index'), 'active' => request()->routeIs('admin.kelas.*')],
                    ['label' => 'Tahun Ajaran', 'icon' => 'calendar', 'href' => route('admin.ajaran.index'), 'active' => request()->routeIs('admin.ajaran.*')],
                ]],
                ['label' => 'Akademik', 'items' => [
                    ['label' => 'Kelulusan & Alumni', 'icon' => 'graduation', 'href' => route('admin.kelulusan.index'), 'active' => request()->routeIs('admin.kelulusan.*')],
                    ['label' => 'Kenaikan Kelas', 'icon' => 'arrow-up', 'href' => route('admin.kenaikan-kelas.index'), 'active' => request()->routeIs('admin.kenaikan-kelas.*')],
                ]],
                ['label' => 'Akun', 'items' => [
                    ['label' => 'Ganti Password', 'icon' => 'lock', 'href' => route('akunpassword.edit'), 'active' => request()->routeIs('akunpassword.*')],
                ]],
            ];
        }

        $tahunAktif = $u?->isSiswa() ? null : once(fn () => \App\Models\TahunAjaran::aktif());
    @endphp

    <div class="min-h-screen lg:flex" x-data="{ sidebar: false }" @keydown.escape.window="sidebar = false">

        {{-- OVERLAY (mobile) --}}
        <div x-show="sidebar" x-cloak x-transition.opacity @click="sidebar = false"
             class="fixed inset-0 z-30 bg-[#0B1E38]/[0.45] backdrop-blur-[2px] lg:hidden" style="display:none;"></div>

        {{-- SIDEBAR --}}
        <aside class="fixed inset-y-0 left-0 z-40 flex w-[264px] max-w-[82vw] flex-col border-r border-[#E8EDF5] bg-white -translate-x-full transition-transform duration-200 ease-out lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:max-w-none lg:shrink-0 lg:translate-x-0"
               :class="sidebar ? '!translate-x-0' : ''">

            {{-- LOGO --}}
            <div class="flex h-16 shrink-0 items-center gap-2.5 border-b border-[#E8EDF5] px-5">
                <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center">
                    <x-brand-logo :size="36" subtitle="SMKN 11 Bandung" subtitle-class="text-[#2F6FED] font-semibold uppercase tracking-[0.16em]" />
                </a>
                <button type="button" @click="sidebar = false" aria-label="Tutup menu"
                        class="ml-auto flex h-8 w-8 items-center justify-center rounded-lg text-[#64748B] transition hover:bg-[#F5F7FB] hover:text-[#0B1E38] lg:hidden">
                    <x-icon name="x" :size="17" />
                </button>
            </div>

            {{-- MENU --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 scrollbar-slim">
                @foreach($menuGroups as $group)
                    <p class="px-2.5 pb-1.5 pt-4 text-[10px] font-semibold uppercase tracking-[0.16em] text-[#94A3B8] first:pt-1">
                        {{ $group['label'] }}
                    </p>
                    <div class="space-y-1">
                        @foreach($group['items'] as $item)
                            <a href="{{ $item['href'] }}"
                               class="group relative flex items-center gap-3 rounded-xl px-2.5 py-2 text-[13px] transition
                                      {{ $item['active'] ? 'bg-[#EEF4FF] font-semibold text-[#2F6FED]' : 'font-medium text-[#475569] hover:bg-[#F5F7FB] hover:text-[#0B1E38]' }}">
                                @if($item['active'])
                                    <span class="absolute left-0 top-1/2 h-5 w-[3px] -translate-y-1/2 rounded-r-full bg-[#2F6FED]"></span>
                                @endif
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition
                                             {{ $item['active'] ? 'bg-white text-[#2F6FED] shadow-sm ring-1 ring-[#2F6FED]/10' : 'bg-[#F5F7FB] text-[#64748B] group-hover:bg-[#EEF4FF] group-hover:text-[#2F6FED]' }}">
                                    <x-icon :name="$item['icon']" :size="16" />
                                </span>
                                <span class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>

            {{-- USER --}}
            <div class="shrink-0 border-t border-[#E8EDF5] p-3">
                <div class="flex items-center gap-3 rounded-xl bg-[#F5F7FB] p-2.5">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#0B1E38] text-[11px] font-semibold text-white">
                        {{ strtoupper(substr($u->nama ?? 'U', 0, 1)) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-[13px] font-semibold text-[#0B1E38]">{{ $u->nama ?? 'Pengguna' }}</p>
                        <p class="truncate text-[11px] text-[#64748B]">{{ $roleLabel }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Keluar" aria-label="Keluar"
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-[#94A3B8] transition hover:bg-white hover:text-red-600">
                            <x-icon name="logout" :size="15" />
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 border-b border-[#E8EDF5] bg-white/90 backdrop-blur">
                <div class="flex h-16 items-center justify-between gap-3 px-4 sm:px-6">
                    <div class="flex min-w-0 items-center gap-2.5">
                        <button type="button" @click="sidebar = true" aria-label="Buka menu"
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-[#0B1E38] transition hover:bg-[#F5F7FB] lg:hidden">
                            <x-icon name="menu" :size="20" />
                        </button>
                        <div class="min-w-0">
                            <div class="hidden items-center gap-1.5 text-[11px] text-[#94A3B8] sm:flex">
                                <span>{{ $roleLabel }}</span>
                                <x-icon name="chevron-right" :size="10" class="text-[#CBD5E1]" />
                                <span class="truncate font-medium text-[#64748B]">{{ $pageTitle }}</span>
                            </div>
                            <h1 class="truncate font-display text-[15px] font-semibold text-[#0B1E38] sm:text-base">{{ $pageTitle }}</h1>
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-1.5 sm:gap-2.5">
                        @if($tahunAktif)
                            <span class="hidden items-center gap-1.5 rounded-full bg-[#EEF4FF] px-3 py-1.5 text-[11px] font-semibold text-[#2F6FED] md:inline-flex">
                                <x-icon name="calendar" :size="12" />
                                {{ $tahunAktif->tahun }}
                            </span>
                        @endif

                        @if($u && ($u->isSiswa() || $u->isKesiswaan()))
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" aria-label="Notifikasi"
                                        class="relative flex h-9 w-9 items-center justify-center rounded-xl text-[#475569] transition hover:bg-[#F5F7FB] hover:text-[#0B1E38]">
                                    <x-icon name="bell" :size="17" />
                                    @php $unread = $u->unreadNotifications->count(); @endphp
                                    @if($unread > 0)
                                        <span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-[#F97316] px-1 text-[10px] font-bold text-white">{{ $unread }}</span>
                                    @endif
                                </button>
                                <div x-show="open" @click.outside="open = false" x-cloak
                                     class="fixed inset-x-3 top-16 z-30 overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white shadow-xl shadow-[#0B1E38]/10 sm:absolute sm:inset-x-auto sm:right-0 sm:top-auto sm:mt-2 sm:w-80">
                                    <div class="flex items-center justify-between border-b border-[#E8EDF5] px-4 py-3">
                                        <span class="text-sm font-semibold text-[#0B1E38]">Notifikasi</span>
                                        @if($unread > 0)
                                            <form method="POST" action="{{ route('notifikasi.baca-semua') }}">
                                                @csrf
                                                <button class="text-[11px] font-semibold text-[#2F6FED] hover:text-[#1B4FC4]">Tandai semua dibaca</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="max-h-72 overflow-y-auto scrollbar-slim">
                                        @forelse($u->notifications->take(8) as $notif)
                                            <form method="POST" action="{{ route('notifikasi.baca', $notif->id) }}">
                                                @csrf
                                                <button type="submit" class="w-full border-b border-[#E8EDF5] px-4 py-3 text-left text-[13px] transition last:border-0 hover:bg-[#F5F7FB] {{ $notif->read_at ? 'text-[#64748B]' : 'font-medium text-[#0B1E38]' }}">
                                                    {{ $notif->data['pesan'] }}
                                                    <span class="mt-0.5 block text-[11px] font-normal text-[#94A3B8]">{{ $notif->created_at->diffForHumans() }}</span>
                                                </button>
                                            </form>
                                        @empty
                                            <div class="px-4 py-8 text-center text-[13px] text-[#94A3B8]">Belum ada notifikasi.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-2 border-l border-[#E8EDF5] pl-2 sm:gap-3 sm:pl-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] text-xs font-semibold text-white">
                                {{ strtoupper(substr($u->nama ?? 'U', 0, 1)) }}
                            </span>
                            <div class="hidden leading-tight md:block">
                                <p class="max-w-[150px] truncate text-[12px] font-semibold text-[#0B1E38]">{{ $u->nama ?? 'Pengguna' }}</p>
                                <p class="text-[10px] text-[#94A3B8]">{{ $roleLabel }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-5 sm:px-6 sm:py-6 lg:px-7">
                @if(session('success'))
                    <div class="mb-4 flex items-start gap-2.5 rounded-xl border border-[#BBF7D0] bg-[#F0FDF4] px-4 py-3 text-sm font-medium text-[#15803D]">
                        <x-icon name="check" :size="16" class="mt-0.5 shrink-0" />
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 flex items-start gap-2.5 rounded-xl border border-[#FECACA] bg-[#FEF2F2] px-4 py-3 text-sm font-medium text-[#B91C1C]">
                        <x-icon name="x" :size="16" class="mt-0.5 shrink-0" />
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
