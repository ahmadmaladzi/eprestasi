<x-app-layout title="Dashboard Admin">
    <form method="GET" class="flex items-center gap-3 mb-6">
        <label class="text-sm text-slate-500 font-medium">Tahun Ajaran:</label>
        <select name="tahun_ajaran" onchange="this.form.submit()"
                class="rounded-lg border-slate-200 text-sm py-2 pl-3 pr-8 shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
            @foreach($semuaTahunAjaran as $ta)
                <option value="{{ $ta->id_ajaran }}" @selected(!$tampilkanSemua && $selectedAjaran && $selectedAjaran->id_ajaran === $ta->id_ajaran)>
                    {{ $ta->tahun }} @if($ta->status === 'Aktif') (Aktif) @endif
                </option>
            @endforeach
            <option value="semua" @selected($tampilkanSemua)>Semua Tahun Ajaran</option>
        </select>
        @if(!$tampilkanSemua && $selectedAjaran)
            <span class="text-xs text-slate-400">Menampilkan data tahun ajaran {{ $selectedAjaran->tahun }}</span>
        @else
            <span class="text-xs text-slate-400">Menampilkan data dari semua tahun ajaran</span>
        @endif
    </form>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-xs text-slate-400 font-medium mb-1">Total Siswa</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalSiswa }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-xs text-slate-400 font-medium mb-1">Total Prestasi</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalPrestasi }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-xs text-slate-400 font-medium mb-1">Belum Diverifikasi</p>
            <p class="text-2xl font-bold text-[#D97706]">{{ $totalBelum }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-xs text-slate-400 font-medium mb-1">Disetujui</p>
            <p class="text-2xl font-bold text-[#16A34A]">{{ $totalDisetujui }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-xs text-slate-400 font-medium mb-1">Ditolak</p>
            <p class="text-2xl font-bold text-red-600">{{ $totalDitolak }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h3 class="font-semibold text-sm text-slate-700 mb-3">Prestasi per Kategori (yang sudah disetujui)</h3>
            <canvas id="chartKategori" height="200"></canvas>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h3 class="font-semibold text-sm text-slate-700 mb-3">Prestasi per Tingkat</h3>
            <canvas id="chartTingkat" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="font-semibold text-sm text-slate-700 mb-4">🏆 Leaderboard Siswa (Prestasi Disetujui Terbanyak)</h3>
        <ol class="space-y-2.5 text-sm">
            @forelse($leaderboard as $i => $s)
                <li class="flex justify-between items-center border-b border-slate-100 pb-2.5 last:border-0">
                    <span class="text-slate-700">
                        <span class="inline-flex w-5 h-5 rounded-full bg-[#2F6FED]/10 text-[#2F6FED] text-xs font-bold items-center justify-center mr-2">{{ $i + 1 }}</span>
                        {{ $s->nama }} <span class="text-slate-400">({{ $s->kelas }} {{ $s->jurusan }})</span>
                    </span>
                    <span class="font-semibold text-slate-900">{{ $s->prestasi_disetujui_count }} prestasi</span>
                </li>
            @empty
                <li class="text-slate-400">Belum ada data.</li>
            @endforelse
        </ol>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('chartKategori'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($perKategori->keys()) !!},
                datasets: [{ data: {!! json_encode($perKategori->values()) !!}, backgroundColor: ['#0B1E38', '#2F6FED', '#F59E0B'] }]
            }
        });
        new Chart(document.getElementById('chartTingkat'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($perTingkat->keys()) !!},
                datasets: [{ label: 'Jumlah Prestasi', data: {!! json_encode($perTingkat->values()) !!}, backgroundColor: '#2F6FED' }]
            },
            options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    </script>
</x-app-layout>