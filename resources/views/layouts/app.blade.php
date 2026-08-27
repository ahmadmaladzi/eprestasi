@props(['title' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'E-Prestasi' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-slate-800 text-white flex-shrink-0 hidden md:block">
            <div class="p-4 text-xl font-bold border-b border-slate-700">E-Prestasi</div>
            <nav class="p-4 space-y-1">
                @auth
                    @if(auth()->user()->isSiswa())
                        <a href="{{ route('siswa.dashboard') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('siswa.dashboard') ? 'bg-slate-700' : '' }}">Dashboard</a>
                        <a href="{{ route('siswa.prestasi.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('siswa.prestasi.*') ? 'bg-slate-700' : '' }}">Prestasi Saya</a>
                        <a href="{{ route('siswa.profil') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('siswa.profil') ? 'bg-slate-700' : '' }}">Profil</a>
                        <a href="{{ route('siswa.portofolio') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Lihat Portofolio</a>
                    @elseif(auth()->user()->isKesiswaan())
                        <a href="{{ route('kesiswaan.prestasi.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('kesiswaan.prestasi.*') ? 'bg-slate-700' : '' }}">Verifikasi Prestasi</a>
                        <a href="{{ route('kesiswaan.profil') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('kesiswaan.profil') ? 'bg-slate-700' : '' }}">Profil</a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.users.*') ? 'bg-slate-700' : '' }}">Kelola Akun Pengguna</a>
                        <a href="{{ route('admin.ajaran.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.ajaran.*') ? 'bg-slate-700' : '' }}">Tahun Ajaran</a>
                    @endif
                @endauth
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white shadow-sm">
                <div class="px-4 py-3 flex items-center justify-between">
                    <h1 class="text-lg font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
                    <div class="flex items-center gap-4">
                        @auth
                            @if(auth()->user()->isSiswa())
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="relative">
                                        🔔
                                        @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                                        @if($unread > 0)
                                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">{{ $unread }}</span>
                                        @endif
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-72 bg-white shadow-lg rounded border z-10">
                                        <div class="p-3 text-sm font-semibold border-b">Notifikasi</div>
                                        <div class="max-h-64 overflow-y-auto">
                                            @forelse(auth()->user()->notifications->take(5) as $notif)
                                                <div class="p-3 text-sm border-b {{ $notif->read_at ? 'text-gray-500' : 'font-medium' }}">
                                                    {{ $notif->data['pesan'] }}
                                                </div>
                                            @empty
                                                <div class="p-3 text-sm text-gray-500">Belum ada notifikasi.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <span class="text-sm text-gray-600">{{ auth()->user()->nama }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="text-sm text-red-600 hover:underline">Keluar</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </header>

            <div class="px-4 pt-4">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded text-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded text-sm">{{ session('error') }}</div>
                @endif
            </div>

            <main class="flex-1 p-4">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>