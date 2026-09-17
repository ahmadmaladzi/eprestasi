<x-app-layout title="Verifikasi Prestasi">
    <form method="GET" class="mb-5 space-y-2.5">
        <div class="flex flex-wrap gap-2.5">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa/prestasi..."
                   class="rounded-xl border-slate-200 text-sm flex-1 min-w-[200px] shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
            <select name="tahun_ajaran" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                @foreach($daftarAjaran as $ajaran)
                    <option value="{{ $ajaran->id_ajaran }}" {{ (string) request('tahun_ajaran', optional($daftarAjaran->firstWhere('status', 'Aktif'))->id_ajaran) === (string) $ajaran->id_ajaran ? 'selected' : '' }}>
                        {{ $ajaran->tahun }}{{ $ajaran->status === 'Aktif' ? ' (Aktif)' : '' }}
                    </option>
                @endforeach
                <option value="semua" {{ request('tahun_ajaran') == 'semua' ? 'selected' : '' }}>Semua Tahun</option>
            </select>
            <select name="status" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                <option value="">Semua Status</option>
                <option value="Belum" {{ request('status') == 'Belum' ? 'selected' : '' }}>Belum</option>
                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <select name="tingkat" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                <option value="">Semua Tingkat</option>
                @foreach(['Sekolah','Kabupaten/Kota','Provinsi','Nasional','Internasional'] as $t)
                    <option value="{{ $t }}" {{ request('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            <select name="kategori" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                <option value="">Semua Kategori</option>
                @foreach(['Akademik','Non Akademik','Kejuaraan'] as $k)
                    <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <select name="asal" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                <option value="">Dalam/Luar Negeri</option>
                <option value="Dalam Negeri" {{ request('asal') == 'Dalam Negeri' ? 'selected' : '' }}>Dalam Negeri</option>
                <option value="Luar Negeri" {{ request('asal') == 'Luar Negeri' ? 'selected' : '' }}>Luar Negeri</option>
            </select>
            <select name="jenis_penyelenggara" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                <option value="">Kementerian/Swasta</option>
                <option value="Kementerian" {{ request('jenis_penyelenggara') == 'Kementerian' ? 'selected' : '' }}>Kementerian</option>
                <option value="Non Kementerian" {{ request('jenis_penyelenggara') == 'Non Kementerian' ? 'selected' : '' }}>Non Kementerian (Swasta)</option>
            </select>
            <select name="puspresnas" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                <option value="">Status Puspresnas</option>
                <option value="ya" {{ request('puspresnas') == 'ya' ? 'selected' : '' }}>Terhubung Puspresnas</option>
                <option value="tidak" {{ request('puspresnas') == 'tidak' ? 'selected' : '' }}>Tidak Terhubung</option>
            </select>
            <button class="bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">Terapkan Filter</button>
            <a href="{{ route('kesiswaan.prestasi.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Reset</a>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Siswa</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Prestasi</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Tingkat</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Tahun Ajaran</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Tanggal</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($prestasi as $item)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-[#0B1E38] text-white flex items-center justify-center text-[10px] font-semibold shrink-0">
                                    {{ strtoupper(substr($item->siswa->nama, 0, 1)) }}
                                </div>
                                <span class="text-slate-700">{{ $item->siswa->nama }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 font-medium text-slate-800">{{ $item->nama_prestasi }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->tingkat }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->tahunAjaran->tahun }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->tanggal->format('d M Y') }}</td>
                        <td class="px-5 py-4">
                            @php
                                $badge = match($item->status) {
                                    'Disetujui' => 'bg-[#22C55E]/10 text-[#16A34A]',
                                    'Ditolak' => 'bg-red-50 text-red-600',
                                    default => 'bg-[#F59E0B]/10 text-[#D97706]',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $item->status }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('kesiswaan.prestasi.show', $item) }}" class="text-[#2F6FED] hover:text-[#1B4FC4] font-medium text-xs">Lihat Detail →</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-14 text-center text-sm text-slate-400">Tidak ada prestasi untuk filter ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $prestasi->links() }}</div>
</x-app-layout>