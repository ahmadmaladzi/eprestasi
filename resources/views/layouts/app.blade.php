@props(['title' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} — E-Prestasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; } .font-display { font-family: 'Space Grotesk', sans-serif; }</style>
</head>
<body class="bg-[#FAF7F0] antialiased">
    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-[#0B1E38] text-white flex-shrink-0 hidden md:flex md:flex-col">
            <div class="flex items-center gap-2.5 px-5 py-5 border-b border-white/10">
                <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M4 4H20V17L12 21L4 17V4Z" stroke="white" stroke-width="1.6" stroke-linejoin="round"/>
                        <path d="M9 11L11 13L15 9" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <p class="font-display text-sm font-semibold">E-Prestasi</p>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">
                @auth
                    @php $u = auth()->user(); @endphp

                    @if($u->isSiswa())
                        <p class="px-3 pb-2 text-[10px] font-semibold tracking-widest text-white/30">MENU SISWA</p>
                        <a href="{{ route('siswa.dashboard') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('siswa.dashboard') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('siswa.dashboard') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Dashboard
                        </a>
                        <a href="{{ route('siswa.prestasi.index') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('siswa.prestasi.*') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('siswa.prestasi.*') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Prestasi Saya
                        </a>
                        <a href="{{ route('siswa.profil') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('siswa.profil') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('siswa.profil') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Profil
                        </a>
                        <a href="{{ route('siswa.portofolio') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition">
                            <span class="w-1.5 h-1.5 rounded-full bg-white/20"></span>
                            Lihat Portofolio
                        </a>
                    @elseif($u->isKesiswaan())
                        <p class="px-3 pb-2 text-[10px] font-semibold tracking-widest text-white/30">MENU KESISWAAN</p>
                        <a href="{{ route('kesiswaan.prestasi.index') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('kesiswaan.prestasi.*') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('kesiswaan.prestasi.*') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Verifikasi Prestasi
                        </a>
                        <a href="{{ route('kesiswaan.statistik') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('kesiswaan.statistik') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('kesiswaan.statistik') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Statistik
                        </a>
                        <a href="{{ route('kesiswaan.profil') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('kesiswaan.profil') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('kesiswaan.profil') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Profil
                        </a>
                    @elseif($u->isAdmin())
                        <p class="px-3 pb-2 text-[10px] font-semibold tracking-widest text-white/30">MENU ADMIN</p>
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.users.*') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Kelola Akun Pengguna
                        </a>
                        <a href="{{ route('admin.ajaran.index') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('admin.ajaran.*') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.ajaran.*') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                            Tahun Ajaran
                        </a>
                    @endif
                @endauth
            </nav>

            <div class="px-3 py-4 border-t border-white/10">
                <a href="{{ route('akunpassword.edit') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm transition {{ request()->routeIs('akunpassword.edit') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('akunpassword.edit') ? 'bg-[#2F6FED]' : 'bg-white/20' }}"></span>
                    Ganti Password
                </a>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-[#0B1E38]/8">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="font-display text-lg font-semibold text-[#0B1E38]">{{ $title ?? 'Dashboard' }}</h1>

                    <div class="flex items-center gap-5">
                        @auth
                            @if(auth()->user()->isSiswa())
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="relative w-9 h-9 rounded-full bg-[#FAF7F0] hover:bg-[#0B1E38]/5 flex items-center justify-center transition">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="#0B1E38" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="#0B1E38" stroke-width="1.6" stroke-linecap="round"/></svg>
                                        @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                                        @if($unread > 0)
                                            <span class="absolute -top-0.5 -right-0.5 bg-[#2F6FED] text-[#0B1E38] text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ $unread }}</span>
                                        @endif
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-cloak
                                         class="absolute right-0 mt-2 w-80 bg-white shadow-xl rounded-xl border border-[#0B1E38]/8 z-20 overflow-hidden">
                                        <div class="px-4 py-3 text-sm font-semibold border-b border-[#0B1E38]/8">Notifikasi</div>
                                        <div class="max-h-64 overflow-y-auto">
                                            @forelse(auth()->user()->notifications->take(5) as $notif)
                                                <div class="px-4 py-3 text-sm border-b border-[#0B1E38]/6 last:border-0 {{ $notif->read_at ? 'text-[#0B1E38]/45' : 'text-[#0B1E38] font-medium' }}">
                                                    {{ $notif->data['pesan'] }}
                                                </div>
                                            @empty
                                                <div class="px-4 py-6 text-sm text-[#0B1E38]/40 text-center">Belum ada notifikasi.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center gap-3 pl-4 border-l border-[#0B1E38]/8">
                                <div class="w-8 h-8 rounded-full bg-[#0B1E38] text-white flex items-center justify-center text-xs font-semibold shrink-0">
                                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                                </div>
                                <span class="text-sm text-[#0B1E38]/70 hidden sm:block">{{ auth()->user()->nama }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="text-xs font-medium text-[#0B1E38]/40 hover:text-red-600 transition">Keluar</button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </header>

            <div class="px-6 pt-5">
                @if(session('success'))
                    <div class="mb-4 bg-[#4ADE80]/10 border border-[#4ADE80]/30 text-[#16803C] px-4 py-3 rounded-xl text-sm font-medium">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">{{ session('error') }}</div>
                @endif
            </div>

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>