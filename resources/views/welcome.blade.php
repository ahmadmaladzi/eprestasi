<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Prestasi - Informasi Prestasi Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white text-slate-900 antialiased">
    <header class="sticky top-0 z-20 bg-[#0B1E38] border-b border-white/10">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] flex items-center justify-center shadow-lg shadow-[#2F6FED]/30">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M4 4H20V17L12 21L4 17V4Z" stroke="white" stroke-width="1.7" stroke-linejoin="round"/>
                        <path d="M9 11L11 13L15 9" stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-white">E-Prestasi</p>
                    <p class="text-[11px] text-white/40">Sistem Informasi Prestasi Siswa</p>
                </div>
            </div>
            <a href="{{ route('login') }}" class="text-sm font-semibold bg-white text-[#0F2540] px-5 py-2.5 rounded-lg hover:bg-white/90 transition shadow-lg shadow-black/10">
                Masuk ke Sistem
            </a>
        </div>
    </header>

    <section class="relative overflow-hidden bg-gradient-to-b from-[#0B1E38] to-[#0F2540]">
        <div class="absolute left-1/2 top-0 -translate-x-1/2 w-[700px] h-[500px] bg-[#2F6FED]/25 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-6 pt-20 pb-28 grid lg:grid-cols-[1.1fr_0.9fr] gap-14 items-center relative">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 rounded-full px-3.5 py-1.5 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4ADE80]"></span>
                    <span class="text-xs font-medium text-white/80">Layanan digital sekolah</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold leading-[1.12] text-white mb-6">
                    Prestasi siswa, tercatat rapi dan
                    <span class="bg-gradient-to-r from-[#5B9CFF] to-[#8FD3FF] bg-clip-text text-transparent">terverifikasi resmi.</span>
                </h1>
                <p class="text-white/60 text-lg leading-relaxed max-w-lg mb-9">
                    Ajukan, verifikasi, dan bagikan pencapaian akademik maupun non-akademik
                    dalam satu sistem terpusat — tanpa berkas fisik yang tercecer.
                </p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-6 py-3.5 rounded-lg font-semibold hover:opacity-90 transition shadow-xl shadow-[#2F6FED]/25">
                        Masuk ke Sistem
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-6 mt-14 pt-8 border-t border-white/10 max-w-lg">
                    <div>
                        <p class="text-2xl font-extrabold text-white">3</p>
                        <p class="text-xs text-white/40 mt-1">Peran Pengguna</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-white">3</p>
                        <p class="text-xs text-white/40 mt-1">Kategori Prestasi</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-white">100%</p>
                        <p class="text-xs text-white/40 mt-1">Terverifikasi</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-6 bg-gradient-to-br from-[#2F6FED]/20 to-transparent rounded-3xl blur-2xl"></div>
                <div class="relative bg-white rounded-2xl shadow-2xl shadow-black/40 overflow-hidden">
                    <div class="px-6 pt-6 pb-4 flex items-center justify-between border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] flex items-center justify-center text-white text-xs font-bold">NS</div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Nama Siswa</p>
                                <p class="text-xs text-slate-400">Kelas &amp; Jurusan</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-semibold text-[#2F6FED] bg-[#2F6FED]/10 px-2.5 py-1 rounded-full">Aktif</span>
                    </div>
                    <div class="px-6 py-5 space-y-3">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <div class="w-8 h-8 rounded-lg bg-[#22C55E]/10 flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="#16A34A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <span class="text-sm text-slate-700 flex-1">Juara 1 LKS Web Design</span>
                            <span class="text-[10px] font-semibold text-[#16A34A]">Disetujui</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <div class="w-8 h-8 rounded-lg bg-[#22C55E]/10 flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="#16A34A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <span class="text-sm text-slate-700 flex-1">Juara 2 Olimpiade Matematika</span>
                            <span class="text-[10px] font-semibold text-[#16A34A]">Disetujui</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                            <div class="w-8 h-8 rounded-lg bg-[#F59E0B]/10 flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#D97706" stroke-width="2"/><path d="M12 7V12L15 14" stroke="#D97706" stroke-width="2" stroke-linecap="round"/></svg>
                            </div>
                            <span class="text-sm text-slate-700 flex-1">Anggota OSIS Terbaik</span>
                            <span class="text-[10px] font-semibold text-[#D97706]">Menunggu</span>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Bagikan portofolio</span>
                        <div class="w-9 h-9 rounded-lg bg-[#0F2540] flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="7" height="7" rx="1" stroke="white" stroke-width="1.5"/><rect x="13" y="4" width="7" height="7" rx="1" stroke="white" stroke-width="1.5"/><rect x="4" y="13" width="7" height="7" rx="1" stroke="white" stroke-width="1.5"/><rect x="14" y="14" width="2" height="2" fill="white"/><rect x="18" y="14" width="2" height="2" fill="white"/><rect x="14" y="18" width="2" height="2" fill="white"/><rect x="18" y="18" width="2" height="2" fill="white"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center max-w-lg mx-auto mb-14">
            <p class="text-xs font-semibold text-[#2F6FED] uppercase tracking-wide mb-2">Cara Kerja</p>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900">Tiga peran, satu alur yang jelas</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-7 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] flex items-center justify-center mb-5 shadow-lg shadow-[#2F6FED]/20">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 4H20V17L12 21L4 17V4Z" stroke="white" stroke-width="1.6" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Siswa</p>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Mengajukan prestasi</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Mengunggah sertifikat dan dokumentasi foto sebagai bukti pencapaian.</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-7 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#F59E0B] to-[#D97706] flex items-center justify-center mb-5 shadow-lg shadow-[#F59E0B]/20">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="white" stroke-width="1.6"/><path d="M8 12L11 15L16 9" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Kesiswaan</p>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Memverifikasi data</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Memeriksa kelengkapan bukti, lalu menyetujui atau menolak dengan catatan.</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-7 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0F2540] to-[#1B3A61] flex items-center justify-center mb-5 shadow-lg shadow-slate-400/20">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="2" stroke="white" stroke-width="1.6"/><path d="M9 9H10V10H9V9ZM14 9H15V10H14V9ZM9 14H10V15H9V14Z" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Publik</p>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Memindai portofolio</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Membuka portofolio siswa melalui QR Code dan mengunduh versi PDF.</p>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="text-center max-w-lg mx-auto mb-14">
                <p class="text-xs font-semibold text-[#2F6FED] uppercase tracking-wide mb-2">Cakupan Sistem</p>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900">Tingkat &amp; kategori prestasi yang tercatat</h2>
                <p class="text-sm text-slate-500 mt-3 leading-relaxed">Setiap prestasi yang diajukan siswa dicatat lengkap dengan jenjang kompetisi dan kategorinya setelah diverifikasi.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200 rounded-2xl p-7">
                    <h3 class="font-bold text-base text-slate-900 mb-4">Tingkat Kompetisi</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full">Sekolah</span>
                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full">Kabupaten/Kota</span>
                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full">Provinsi</span>
                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full">Nasional</span>
                        <span class="text-xs font-semibold text-white bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-3 py-1.5 rounded-full">Internasional</span>
                    </div>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-7">
                    <h3 class="font-bold text-base text-slate-900 mb-4">Kategori Prestasi</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full">Akademik</span>
                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full">Non Akademik</span>
                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full">Kejuaraan</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed">Kategori ditentukan oleh pihak kesiswaan pada saat prestasi disetujui, sesuai bukti yang dilampirkan siswa.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center max-w-lg mx-auto mb-14">
            <p class="text-xs font-semibold text-[#2F6FED] uppercase tracking-wide mb-2">Keunggulan</p>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900">Kenapa pakai E-Prestasi</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="p-2">
                <div class="w-11 h-11 rounded-xl bg-[#2F6FED]/10 flex items-center justify-center mb-4">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 2L4 6V12C4 16.5 7.5 20.7 12 22C16.5 20.7 20 16.5 20 12V6L12 2Z" stroke="#2F6FED" stroke-width="1.6" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-1.5">Terverifikasi resmi</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Setiap prestasi diperiksa langsung oleh pihak kesiswaan sebelum tercatat, jadi datanya bisa dipertanggungjawabkan.</p>
            </div>
            <div class="p-2">
                <div class="w-11 h-11 rounded-xl bg-[#F59E0B]/10 flex items-center justify-center mb-4">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="14" rx="2" stroke="#D97706" stroke-width="1.6"/><path d="M3 9H21" stroke="#D97706" stroke-width="1.6"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-1.5">Tanpa berkas fisik</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Sertifikat dan dokumentasi diunggah langsung ke sistem, tidak perlu bolak-balik cetak dan menyerahkan berkas.</p>
            </div>
            <div class="p-2">
                <div class="w-11 h-11 rounded-xl bg-[#0F2540]/10 flex items-center justify-center mb-4">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="7" height="7" rx="1" stroke="#0F2540" stroke-width="1.5"/><rect x="13" y="4" width="7" height="7" rx="1" stroke="#0F2540" stroke-width="1.5"/><rect x="4" y="13" width="7" height="7" rx="1" stroke="#0F2540" stroke-width="1.5"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-1.5">Portofolio siap bagi</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Portofolio siswa bisa dibagikan lewat QR Code dan dilihat siapa saja tanpa perlu login ke sistem.</p>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 border-y border-slate-100">
        <div class="max-w-3xl mx-auto px-6 py-20">
            <div class="text-center mb-12">
                <p class="text-xs font-semibold text-[#2F6FED] uppercase tracking-wide mb-2">FAQ</p>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900">Pertanyaan yang sering ditanyakan</h2>
            </div>

            <div class="space-y-3">
                <details class="group bg-white border border-slate-200 rounded-xl px-5 py-4">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-sm text-slate-900 list-none">
                        Siapa saja yang bisa punya akun di sistem ini?
                        <svg class="shrink-0 group-open:rotate-45 transition" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/></svg>
                    </summary>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Akun dibuat oleh admin sekolah untuk siswa dan pihak kesiswaan. Siswa dan kesiswaan tidak bisa mendaftar sendiri.</p>
                </details>
                <details class="group bg-white border border-slate-200 rounded-xl px-5 py-4">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-sm text-slate-900 list-none">
                        Bagaimana alur pengajuan prestasi oleh siswa?
                        <svg class="shrink-0 group-open:rotate-45 transition" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/></svg>
                    </summary>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Siswa login, mengisi data prestasi (nama, penyelenggara, tingkat, tanggal), lalu mengunggah sertifikat dan foto dokumentasi. Setelah itu, statusnya menunggu verifikasi kesiswaan.</p>
                </details>
                <details class="group bg-white border border-slate-200 rounded-xl px-5 py-4">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-sm text-slate-900 list-none">
                        Apa yang terjadi kalau prestasi ditolak?
                        <svg class="shrink-0 group-open:rotate-45 transition" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/></svg>
                    </summary>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Pihak kesiswaan akan menyertakan catatan alasan penolakan, sehingga siswa tahu apa yang perlu diperbaiki atau dilengkapi.</p>
                </details>
                <details class="group bg-white border border-slate-200 rounded-xl px-5 py-4">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-sm text-slate-900 list-none">
                        Bagaimana publik bisa melihat portofolio siswa?
                        <svg class="shrink-0 group-open:rotate-45 transition" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/></svg>
                    </summary>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">Setiap siswa punya QR Code unik yang mengarah ke halaman portofolio publik, lengkap dengan opsi unduh versi PDF, tanpa perlu login.</p>
                </details>
            </div>
        </div>
    </section>

    <footer class="bg-[#0B1E38] text-white/40 border-t border-white/10">
        <div class="max-w-6xl mx-auto px-6 py-6 text-center text-xs">
            E-Prestasi &copy; {{ date('Y') }} — Sistem Informasi Prestasi Siswa
        </div>
    </footer>
</body>
</html>