<x-app-layout title="Kelola Akun Pengguna">
    <div class="space-y-4">

        {{-- RINGKASAN --}}
        <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">
            <x-ui.stat-card label="Total Akun" :value="$totalUser" icon="users" hint="semua role" tone="bg-[#EEF4FF] text-[#2F6FED]" />
            <x-ui.stat-card label="Siswa" :value="$totalSiswa" icon="graduation" hint="akun siswa aktif" tone="bg-[#ECFDF5] text-[#16A34A]" />
            <x-ui.stat-card label="Kesiswaan" :value="$totalKesiswaan" icon="clipboard" hint="verifikator prestasi" tone="bg-[#FFF7ED] text-[#F97316]" />
            <x-ui.stat-card label="Admin" :value="$totalAdmin" icon="shield" hint="pengelola sistem" tone="bg-[#F5F3FF] text-[#8B5CF6]" />
        </div>

        <section class="overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
            {{-- TOOLBAR --}}
            <div class="flex flex-col gap-3 border-b border-[#E8EDF5] p-4 lg:flex-row lg:items-center lg:justify-between">
                <form method="GET" class="flex flex-wrap items-center gap-2">
                    <div class="relative w-full sm:w-60">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                            <x-icon name="search" :size="15" />
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                               class="w-full rounded-xl border-[#E2E8F0] py-2 pl-9 pr-3 text-[13px] text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                    </div>
                    <select name="role"
                            class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Role</option>
                        <option value="siswa" @selected(request('role') === 'siswa')>Siswa</option>
                        <option value="kesiswaan" @selected(request('role') === 'kesiswaan')>Kesiswaan</option>
                        <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                    </select>

                    <select name="kelas"
                            class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasOptions as $kls)
                            <option value="{{ $kls }}" @selected(request('kelas') === $kls)>{{ $kls }}</option>
                        @endforeach
                    </select>

                    <select name="status_kelulusan"
                            class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Status</option>
                        <option value="Aktif" @selected(request('status_kelulusan') === 'Aktif')>Aktif</option>
                        <option value="Lulus" @selected(request('status_kelulusan') === 'Lulus')>Lulus</option>
                        <option value="Keluar" @selected(request('status_kelulusan') === 'Keluar')>Keluar</option>
                    </select>

                    <select name="per_page"
                            class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="15" @selected(request('per_page') == 15)>15 / hlm</option>
                        <option value="30" @selected(request('per_page') == 30)>30 / hlm</option>
                        <option value="50" @selected(request('per_page') == 50)>50 / hlm</option>
                        <option value="100" @selected(request('per_page') == 100)>100 / hlm</option>
                    </select>

                    <button class="inline-flex items-center gap-1.5 rounded-xl bg-[#2F6FED] px-3.5 py-2 text-[13px] font-semibold text-white transition hover:bg-[#1B4FC4]">
                        <x-icon name="filter" :size="14" />
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'role', 'kelas', 'status_kelulusan', 'per_page']))
                        <a href="{{ route('admin.users.index') }}" class="text-[12px] font-medium text-[#94A3B8] transition hover:text-[#475569]">Reset</a>
                    @endif
                </form>

                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.users.import.form') }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-[#E8EDF5] bg-white px-3.5 py-2 text-[13px] font-semibold text-[#475569] transition hover:bg-[#F8FAFC]">
                        <x-icon name="upload" :size="14" class="text-[#2F6FED]" />
                        Import Excel
                    </a>
                    <a href="{{ route('admin.users.create') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-4 py-2 text-[13px] font-semibold text-white shadow-lg shadow-[#2F6FED]/20 transition hover:opacity-90">
                        <x-icon name="plus" :size="14" />
                        Tambah User
                    </a>
                </div>
            </div>

            {{-- TABLE HEADER --}}
            <div class="flex items-center justify-between gap-3 px-5 py-3.5">
                <div>
                    <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Daftar Pengguna</h2>
                    <p class="mt-0.5 text-[11px] text-[#94A3B8]">Kelola akses akun siswa, kesiswaan, dan admin.</p>
                </div>
                <span class="shrink-0 rounded-full bg-[#F5F7FB] px-2.5 py-1 text-[10.5px] font-semibold text-[#64748B]">{{ $users->total() }} akun</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[680px] text-sm">
                    <thead class="border-y border-[#E8EDF5] bg-[#F8FAFC] text-left">
                        <tr>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Nama</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Email</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Role</th>
                            <th class="px-5 py-3 text-right text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($users as $user)
                            @php
                                $roleBadge = match($user->role) {
                                    'admin' => 'bg-[#F1F5F9] text-[#0B1E38]',
                                    'kesiswaan' => 'bg-[#FFF7ED] text-[#C2410C]',
                                    default => 'bg-[#EEF4FF] text-[#1B4FC4]',
                                };
                            @endphp
                            <tr class="transition hover:bg-[#F8FAFC]">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] text-[10px] font-semibold text-white">
                                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                                        </span>
                                        <div>
                                            <span class="font-medium text-[#0B1E38]">{{ $user->nama }}</span>
                                            @if($user->role === 'siswa' && $user->siswa)
                                                <div class="text-[11px] text-[#64748B]">
                                                    {{ $user->siswa->kelas }} &middot; {{ $user->siswa->jurusan }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-[13px] text-[#64748B]">{{ $user->email }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[10.5px] font-semibold capitalize {{ $roleBadge }}">{{ $user->role }}</span>
                                        @if($user->role === 'siswa' && $user->siswa)
                                            @if($user->siswa->status_kelulusan === 'Aktif')
                                                <span class="inline-flex items-center gap-1 rounded-full bg-[#ECFDF5] px-2 py-0.5 text-[10px] font-semibold text-[#15803D]">
                                                    <span class="h-1 w-1 rounded-full bg-[#16A34A]"></span> Aktif
                                                </span>
                                            @elseif($user->siswa->status_kelulusan === 'Keluar')
                                                <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-semibold text-rose-700">
                                                    <span class="h-1 w-1 rounded-full bg-rose-500"></span> Keluar
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-full bg-[#FEF3C7] px-2 py-0.5 text-[10px] font-semibold text-[#92400E]">
                                                    <span class="h-1 w-1 rounded-full bg-[#F59E0B]"></span> {{ $user->siswa->status_kelulusan }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.users.edit', $user) }}" title="Edit pengguna"
                                           class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] text-[#64748B] transition hover:border-[#2F6FED]/30 hover:bg-[#EEF4FF] hover:text-[#2F6FED]">
                                            <x-icon name="edit" :size="14" />
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" onsubmit="return confirm('Reset password user ini?')">
                                            @csrf
                                            <button type="submit" title="Reset Password"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] text-[#64748B] transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-600">
                                                <x-icon name="key" :size="14" />
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus pengguna"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] text-[#94A3B8] transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                                                <x-icon name="trash" :size="14" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <x-ui.empty-state icon="users" title="Belum ada pengguna"
                                                      description="Tambahkan akun baru atau import dari file Excel untuk memulai." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div>{{ $users->links() }}</div>
    </div>
</x-app-layout>
