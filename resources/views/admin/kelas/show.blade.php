<x-app-layout :title="'Detail Kelas ' . $kela->nama_kelas">
    <div class="space-y-4">
        {{-- HEADER --}}
        <section class="card overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-[#E8EDF5] p-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-3">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <x-icon name="school" :size="20" />
                    </span>
                    <div class="min-w-0">
                        <h1 class="font-display text-lg font-semibold text-[#0B1E38]">{{ $kela->nama_kelas }}</h1>
                        <div class="mt-1 flex flex-wrap items-center gap-2 text-[12px] text-[#64748B]">
                            <span>Tingkat {{ $kela->tingkat }}</span>
                            <span class="text-[#CBD5E1]">•</span>
                            <span>{{ $kela->jurusan }}</span>
                            <span class="text-[#CBD5E1]">•</span>
                            <span class="font-semibold text-[#2F6FED]">{{ $siswa->total() }} siswa</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.kelas.index') }}" class="btn-ghost">
                    <x-icon name="arrow-left" :size="14" />
                    Kembali
                </a>
            </div>

            {{-- SEARCH --}}
            <div class="p-5">
                <form method="GET" class="flex flex-wrap items-center gap-2">
                    <div class="relative w-full sm:w-72">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                            <x-icon name="search" :size="15" />
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS..."
                               class="w-full rounded-xl border-[#E2E8F0] py-2 pl-9 pr-3 text-[13px] text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                    </div>
                    <button class="inline-flex items-center gap-1.5 rounded-xl bg-[#2F6FED] px-3.5 py-2 text-[13px] font-semibold text-white transition hover:bg-[#1B4FC4]">
                        <x-icon name="search" :size="14" />
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.kelas.show', $kela) }}" class="text-[12px] font-medium text-[#94A3B8] transition hover:text-[#475569]">Reset</a>
                    @endif
                </form>
            </div>
        </section>

        {{-- TABEL SISWA --}}
        <section class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-sm">
                    <thead class="border-b border-[#E8EDF5] bg-[#F8FAFC] text-left">
                        <tr>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Nama Siswa</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">NIS</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Email</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">No HP</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($siswa as $s)
                            <tr class="transition hover:bg-[#F8FAFC]">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        @if($s->foto_profil)
                                            <img src="{{ asset('storage/' . $s->foto_profil) }}" alt="{{ $s->nama }}" class="h-8 w-8 shrink-0 rounded-full object-cover">
                                        @else
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0B1E38] text-[10px] font-semibold text-white">
                                                {{ strtoupper(substr($s->nama, 0, 1)) }}
                                            </span>
                                        @endif
                                        <span class="font-medium text-[#0B1E38]">{{ $s->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $s->nis }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $s->email ?: '—' }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $s->no_hp ?: '—' }}</td>
                                <td class="px-5 py-3.5">
                                    @if($s->status_kelulusan === 'Aktif')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#ECFDF5] px-2.5 py-1 text-[10.5px] font-semibold text-[#15803D]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#16A34A]"></span> Aktif
                                        </span>
                                    @elseif($s->status_kelulusan === 'Keluar')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[10.5px] font-semibold text-rose-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Keluar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#FEF3C7] px-2.5 py-1 text-[10.5px] font-semibold text-[#92400E]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#F59E0B]"></span> {{ $s->status_kelulusan }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <x-ui.empty-state icon="users" title="Tidak ada siswa"
                                                      description="Belum ada siswa terdaftar di kelas ini." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        @if($siswa->hasPages())
            <div>{{ $siswa->links() }}</div>
        @endif
    </div>
</x-app-layout>
