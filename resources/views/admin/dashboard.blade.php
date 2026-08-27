<x-app-layout title="Dashboard Admin">
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <p class="text-sm text-gray-500">Total Siswa</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalSiswa }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <p class="text-sm text-gray-500">Total Prestasi</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalPrestasi }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <p class="text-sm text-gray-500">Belum Diverifikasi</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $totalBelum }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <p class="text-sm text-gray-500">Disetujui</p>
            <p class="text-2xl font-bold text-green-600">{{ $totalDisetujui }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <p class="text-sm text-gray-500">Ditolak</p>
            <p class="text-2xl font-bold text-red-600">{{ $totalDitolak }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h3 class="font-medium text-gray-700 mb-3">Prestasi per Kategori (yang sudah disetujui)</h3>
            <canvas id="chartKategori" height="200"></canvas>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h3 class="font-medium text-gray-700 mb-3">Prestasi per Tingkat</h3>
            <canvas id="chartTingkat" height="200"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-4">
        <h3 class="font-medium text-gray-700 mb-3">🏆 Leaderboard Siswa (Prestasi Disetujui Terbanyak)</h3>
        <ol class="space-y-2 text-sm">
            @forelse($leaderboard as $i => $s)
                <li class="flex justify-between border-b pb-2">
                    <span>{{ $i + 1 }}. {{ $s->nama }} ({{ $s->kelas }} {{ $s->jurusan }})</span>
                    <span class="font-semibold">{{ $s->prestasi_disetujui_count }} prestasi</span>
                </li>
            @empty
                <li class="text-gray-500">Belum ada data.</li>
            @endforelse
        </ol>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('chartKategori'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($perKategori->keys()) !!},
                datasets: [{ data: {!! json_encode($perKategori->values()) !!}, backgroundColor: ['#1e293b', '#0ea5e9', '#f59e0b'] }]
            }
        });
        new Chart(document.getElementById('chartTingkat'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($perTingkat->keys()) !!},
                datasets: [{ label: 'Jumlah Prestasi', data: {!! json_encode($perTingkat->values()) !!}, backgroundColor: '#1e293b' }]
            },
            options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    </script>
</x-app-layout>
