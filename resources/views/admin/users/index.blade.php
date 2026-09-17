<x-app-layout title="Kelola Akun Pengguna">
    <div class="flex justify-between items-center mb-5 flex-wrap gap-3">
        <form method="GET" class="flex gap-2.5 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..."
                   class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
            <select name="role" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                <option value="">Semua Role</option>
                <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                <option value="kesiswaan" {{ request('role') == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-50 transition">Filter</button>
        </form>
        <div class="flex gap-2.5">
            <a href="{{ route('admin.users.import.form') }}"
               class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-50 transition">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 15V3M12 3L8 7M12 3L16 7" stroke="#2F6FED" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 17V19C4 20.1 4.9 21 6 21H18C19.1 21 20 20.1 20 19V17" stroke="#2F6FED" stroke-width="2" stroke-linecap="round"/></svg>
                Import Excel
            </a>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="white" stroke-width="2.2" stroke-linecap="round"/></svg>
                Tambah User
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Nama</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Email</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Role</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-[#0B1E38] text-white flex items-center justify-center text-[10px] font-semibold shrink-0">
                                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-800">{{ $user->nama }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ $user->email }}</td>
                        <td class="px-5 py-4">
                            @php
                                $roleBadge = match($user->role) {
                                    'admin' => 'bg-[#0B1E38]/10 text-[#0B1E38]',
                                    'kesiswaan' => 'bg-[#F59E0B]/10 text-[#D97706]',
                                    default => 'bg-[#2F6FED]/10 text-[#2F6FED]',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize {{ $roleBadge }}">{{ $user->role }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-700 font-medium text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-14 text-center text-sm text-slate-400">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</x-app-layout>