<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Prestasi — Rekam Jejak Prestasi Siswa</title>
    <meta name="description" content="E-Prestasi membantu siswa mencatat, memverifikasi, dan membagikan prestasi secara digital.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --blue:#2563eb; --navy:#102a43; --muted:#64748b; }
        * { box-sizing:border-box; }
        body { margin:0; font-family:'DM Sans',sans-serif; color:var(--navy); background:#fff; }
        h1,h2,h3,h4 { font-family:'Plus Jakarta Sans',sans-serif; }
        .hero-bg {
            background:
                radial-gradient(circle at 82% 22%, rgba(96,165,250,.22), transparent 24%),
                radial-gradient(circle at 12% 86%, rgba(45,212,191,.13), transparent 23%),
                linear-gradient(180deg,#f8fbff 0%,#ffffff 78%);
        }
        .dot-grid { background-image:radial-gradient(rgba(37,99,235,.12) 1px,transparent 1px); background-size:22px 22px; }
        .nav-shadow { box-shadow:0 10px 35px rgba(15,43,67,.07); }
        .soft-shadow { box-shadow:0 25px 70px rgba(15,43,67,.11); }
        .card-shadow { box-shadow:0 16px 45px rgba(15,43,67,.08); }
        .float { animation:float 6s ease-in-out infinite; }
        .float-slow { animation:float 7.5s ease-in-out -1.5s infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-9px)} }
        .reveal { animation:reveal .7s ease both; }
        @keyframes reveal { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
        .section-pad { padding:96px 0; }
        details summary::-webkit-details-marker { display:none; }
        details[open] .plus { transform:rotate(45deg); }
        @media(max-width:767px){ .section-pad{padding:72px 0;} }
    </style>
</head>
<body class="antialiased">

<!-- NAVBAR -->
<header class="absolute inset-x-0 top-0 z-50">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 pt-5">
        <nav class="flex items-center justify-between rounded-2xl bg-white/90 backdrop-blur-xl border border-slate-200/80 px-4 sm:px-5 py-3 nav-shadow">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <span class="relative w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-600/25 group-hover:-translate-y-0.5 transition">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M8 4h8v3.5c0 3.4-1.8 5.6-4 5.6S8 10.9 8 7.5V4Z" fill="currentColor"/>
                        <path d="M8 6H4.8v1.3c0 3.1 1.7 5 4.5 5M16 6h3.2v1.3c0 3.1-1.7 5-4.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M12 13.2V17M8.5 20h7M10 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                    <span class="absolute -right-1 -top-1 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white"></span>
                </span>
                <span>
                    <span class="block text-sm font-extrabold tracking-tight text-slate-900">E-Prestasi</span>
                    <span class="block text-[10px] text-slate-400">Sistem Prestasi Siswa</span>
                </span>
            </a>

            <div class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-500">
                <a href="#tentang" class="hover:text-blue-600 transition">Tentang</a>
                <a href="#fitur" class="hover:text-blue-600 transition">Fitur</a>
                <a href="#alur" class="hover:text-blue-600 transition">Cara Kerja</a>
                <a href="#faq" class="hover:text-blue-600 transition">FAQ</a>
            </div>

            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 text-white px-4 sm:px-5 py-2.5 text-sm font-bold shadow-lg shadow-blue-600/20 hover:bg-blue-700 hover:-translate-y-0.5 transition">
                Masuk <span>→</span>
            </a>
        </nav>
    </div>
</header>

<!-- HERO -->
<section class="hero-bg relative overflow-hidden min-h-[760px] lg:min-h-[790px] pt-32 pb-20">
    <div class="absolute inset-0 dot-grid opacity-50 pointer-events-none"></div>
    <div class="absolute -left-28 top-28 w-72 h-72 rounded-full bg-blue-200/25 blur-2xl"></div>
    <div class="absolute right-[-80px] bottom-10 w-96 h-96 rounded-full bg-cyan-100/60 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-5 sm:px-8">
        <div class="grid lg:grid-cols-[.88fr_1.12fr] gap-10 xl:gap-16 items-center">
            <div class="reveal relative z-10">
                <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 border border-blue-100 px-3.5 py-2 text-xs font-bold text-blue-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Platform digital prestasi sekolah
                </div>

                <h1 class="mt-6 text-4xl sm:text-5xl xl:text-[62px] leading-[1.08] tracking-[-.045em] font-extrabold text-slate-950">
                    Prestasimu bukan sekadar angka.<br>
                    <span class="text-blue-600">Jadikan sebuah cerita.</span>
                </h1>

                <p class="mt-6 max-w-xl text-base sm:text-lg leading-8 text-slate-500">
                    E-Prestasi membantu siswa mencatat pencapaian, sekolah memverifikasi data, dan semua prestasi tersusun menjadi portofolio digital yang rapi.
                </p>

                <div class="mt-8 flex items-center gap-6 sm:gap-8">
                    <div><b class="text-2xl font-extrabold text-slate-900">3</b><p class="text-xs text-slate-400 mt-1">Peran pengguna</p></div>
                    <div class="w-px h-9 bg-slate-200"></div>
                    <div><b class="text-2xl font-extrabold text-slate-900">QR</b><p class="text-xs text-slate-400 mt-1">Portofolio publik</p></div>
                    <div class="w-px h-9 bg-slate-200"></div>
                    <div><b class="text-2xl font-extrabold text-slate-900">24/7</b><p class="text-xs text-slate-400 mt-1">Akses digital</p></div>
                </div>
            </div>

            <!-- HERO VISUAL — siswa saja, tanpa kartu yang menabrak gambar -->
            <div class="relative min-h-[470px] sm:min-h-[525px] lg:min-h-[570px] reveal overflow-visible" style="animation-delay:.12s">
                <!-- soft backdrop -->
                <div class="absolute left-[8%] right-[3%] top-[9%] bottom-[8%] rounded-[45%] bg-gradient-to-br from-blue-100/80 via-sky-50 to-cyan-50"></div>
                <div class="absolute left-[18%] top-[13%] w-20 h-20 rounded-full bg-white/80 blur-sm"></div>
                <div class="absolute right-[10%] top-[18%] w-16 h-16 rounded-full bg-blue-100/70"></div>
                <div class="absolute right-[7%] bottom-[13%] w-24 h-24 rounded-full bg-cyan-100/60 blur-md"></div>

                <!-- gambar siswa: diberi ruang atas agar kepala tidak kepotong -->
                <div class="relative z-10 h-full flex items-end justify-center px-2 sm:px-5 lg:px-2 pt-8 sm:pt-10 lg:pt-12">
                    <img
                        src="{{ asset('images/hero-students.png') }}"
                        alt="Ilustrasi tiga siswa berprestasi di lingkungan sekolah"
                        class="block w-[90%] sm:w-[88%] lg:w-[92%] max-w-[650px] max-h-[455px] sm:max-h-[485px] lg:max-h-[505px] h-auto object-contain object-center translate-y-[2px] drop-shadow-[0_28px_35px_rgba(37,99,235,0.12)]"
                        loading="eager">
                </div>

                <!-- dekorasi kecil, tidak menutup siswa -->
                <div class="absolute z-20 left-[5%] top-[24%] w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-white border border-blue-100 shadow-lg shadow-blue-900/10 flex items-center justify-center rotate-[-8deg]">
                    <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 3.5 14.2 8l5 .7-3.6 3.5.9 5-4.5-2.4-4.5 2.4.9-5-3.6-3.5 5-.7L12 3.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    </svg>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- TRUST -->
<section class="relative -mt-10 z-20 px-5 sm:px-8">
    <div class="max-w-6xl mx-auto rounded-3xl bg-white border border-slate-100 card-shadow p-5 sm:p-7 grid md:grid-cols-3 gap-5">
        <div class="flex items-center gap-4 md:border-r border-slate-100 md:pr-5"><span class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">✓</span><div><b class="text-sm">Data terverifikasi</b><p class="text-xs text-slate-400 mt-1">Lebih terpercaya dan rapi</p></div></div>
        <div class="flex items-center gap-4 md:border-r border-slate-100 md:pr-5"><span class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">↗</span><div><b class="text-sm">Portofolio digital</b><p class="text-xs text-slate-400 mt-1">Mudah dibagikan kapan saja</p></div></div>
        <div class="flex items-center gap-4"><span class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">⌁</span><div><b class="text-sm">Tersimpan terpusat</b><p class="text-xs text-slate-400 mt-1">Tidak perlu takut data tercecer</p></div></div>
    </div>
</section>

<!-- TENTANG -->
<section id="tentang" class="section-pad max-w-7xl mx-auto px-5 sm:px-8 scroll-mt-10">
    <div class="grid lg:grid-cols-2 gap-14 items-center">
        <div>
            <p class="text-xs font-extrabold tracking-[.18em] uppercase text-blue-600">Tentang E-Prestasi</p>
            <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-[-.035em] leading-tight text-slate-950">Satu tempat untuk <span class="text-blue-600">setiap pencapaian.</span></h2>
            <p class="mt-5 text-slate-500 leading-7 max-w-xl">Mulai dari memenangkan lomba sampai mendapatkan sertifikat, semuanya bisa dicatat dan disusun menjadi rekam jejak yang lebih bermakna.</p>
            <div class="mt-8 space-y-5">
                <div class="flex gap-4"><span class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs font-extrabold shrink-0">01</span><div><b class="text-sm">Siswa mengajukan</b><p class="text-sm text-slate-400 mt-1">Isi prestasi dan unggah bukti secara digital.</p></div></div>
                <div class="flex gap-4"><span class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs font-extrabold shrink-0">02</span><div><b class="text-sm">Kesiswaan memverifikasi</b><p class="text-sm text-slate-400 mt-1">Data diperiksa sebelum dinyatakan valid.</p></div></div>
                <div class="flex gap-4"><span class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs font-extrabold shrink-0">03</span><div><b class="text-sm">Menjadi portofolio</b><p class="text-sm text-slate-400 mt-1">Profil prestasi siap dilihat melalui QR Code.</p></div></div>
            </div>
        </div>

        <div class="relative">
            <div class="rounded-[34px] bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-100 p-6 sm:p-9 overflow-hidden">
                <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-blue-200/40"></div>
                <div class="relative rounded-[26px] bg-white p-5 sm:p-7 soft-shadow">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-5"><div><p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Ringkasan prestasi</p><p class="font-extrabold mt-1">Tahun Ajaran 2026/2027</p></div><span class="px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">Aktif</span></div>
                    <div class="grid grid-cols-2 gap-3 mt-5"><div class="rounded-2xl bg-blue-50 p-4"><b class="text-2xl text-blue-700">128</b><p class="text-xs text-blue-700/60 mt-1">Prestasi tercatat</p></div><div class="rounded-2xl bg-amber-50 p-4"><b class="text-2xl text-amber-600">74</b><p class="text-xs text-amber-700/60 mt-1">Siswa berprestasi</p></div></div>
                    <div class="mt-4 rounded-2xl border border-slate-100 p-4"><div class="flex justify-between mb-3"><b class="text-xs">Distribusi tingkat</b><span class="text-[10px] text-slate-400">Total 128</span></div><div class="space-y-3"><div class="flex items-center gap-2"><span class="w-14 text-[9px] text-slate-400">Nasional</span><div class="h-2 flex-1 bg-slate-100 rounded-full"><div class="h-full w-[72%] bg-blue-500 rounded-full"></div></div><b class="text-[9px]">72</b></div><div class="flex items-center gap-2"><span class="w-14 text-[9px] text-slate-400">Provinsi</span><div class="h-2 flex-1 bg-slate-100 rounded-full"><div class="h-full w-[48%] bg-cyan-400 rounded-full"></div></div><b class="text-[9px]">31</b></div><div class="flex items-center gap-2"><span class="w-14 text-[9px] text-slate-400">Kota</span><div class="h-2 flex-1 bg-slate-100 rounded-full"><div class="h-full w-[36%] bg-emerald-400 rounded-full"></div></div><b class="text-[9px]">25</b></div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FITUR -->
<section id="fitur" class="bg-slate-50 border-y border-slate-100 section-pad scroll-mt-10">
    <div class="max-w-7xl mx-auto px-5 sm:px-8">
        <div class="max-w-2xl"><p class="text-xs font-extrabold tracking-[.18em] uppercase text-blue-600">Fitur utama</p><h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-[-.035em]">Semua yang dibutuhkan, <span class="text-blue-600">dalam satu platform.</span></h2><p class="mt-4 text-slate-500 leading-7">Sederhana untuk siswa, terkontrol untuk sekolah, dan mudah dipahami.</p></div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mt-12">
            <div class="bg-white rounded-3xl border border-slate-100 p-6 card-shadow hover:-translate-y-1 transition"><div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5">✦</div><b>Catat prestasi</b><p class="text-sm text-slate-400 leading-6 mt-2">Masukkan pencapaian dan bukti tanpa proses yang ribet.</p></div>
            <div class="bg-white rounded-3xl border border-slate-100 p-6 card-shadow hover:-translate-y-1 transition"><div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5">✓</div><b>Verifikasi data</b><p class="text-sm text-slate-400 leading-6 mt-2">Kesiswaan memeriksa data sebelum menjadi prestasi valid.</p></div>
            <div class="bg-white rounded-3xl border border-slate-100 p-6 card-shadow hover:-translate-y-1 transition"><div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-5">▣</div><b>Portofolio QR</b><p class="text-sm text-slate-400 leading-6 mt-2">Satu QR Code untuk membuka rekam jejak siswa.</p></div>
            <div class="bg-white rounded-3xl border border-slate-100 p-6 card-shadow hover:-translate-y-1 transition"><div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center mb-5">◔</div><b>Statistik sekolah</b><p class="text-sm text-slate-400 leading-6 mt-2">Pantau perkembangan prestasi dengan data yang jelas.</p></div>
        </div>
    </div>
</section>

<!-- ALUR -->
<section id="alur" class="section-pad max-w-7xl mx-auto px-5 sm:px-8 scroll-mt-10">
    <div class="text-center max-w-2xl mx-auto"><p class="text-xs font-extrabold tracking-[.18em] uppercase text-blue-600">Cara kerja</p><h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-[-.035em]">Dari prestasi menjadi <span class="text-blue-600">rekam jejak.</span></h2><p class="mt-4 text-slate-500 leading-7">Tiga langkah sederhana yang membuat pencapaian lebih teratur.</p></div>
    <div class="relative grid md:grid-cols-3 gap-8 mt-14">
        <div class="hidden md:block absolute top-8 left-[17%] right-[17%] border-t border-dashed border-slate-200"></div>
        <div class="relative text-center"><div class="mx-auto w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-extrabold shadow-xl">01</div><b class="block mt-6">Ajukan prestasi</b><p class="text-sm text-slate-400 leading-6 mt-2 max-w-xs mx-auto">Lengkapi informasi lomba, tingkat, dan bukti pencapaian.</p></div>
        <div class="relative text-center"><div class="mx-auto w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-extrabold shadow-xl shadow-blue-600/20">02</div><b class="block mt-6">Verifikasi sekolah</b><p class="text-sm text-slate-400 leading-6 mt-2 max-w-xs mx-auto">Kesiswaan meninjau dan memberikan status verifikasi.</p></div>
        <div class="relative text-center"><div class="mx-auto w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center font-extrabold shadow-xl shadow-emerald-500/20">03</div><b class="block mt-6">Bagikan portofolio</b><p class="text-sm text-slate-400 leading-6 mt-2 max-w-xs mx-auto">Profil prestasi dapat dilihat publik melalui QR Code.</p></div>
    </div>
</section>

<!-- CTA -->
<section class="px-5 sm:px-8 pb-24">
    <div class="max-w-7xl mx-auto rounded-[36px] overflow-hidden relative bg-slate-950">
        <div class="absolute -right-20 -top-32 w-96 h-96 rounded-full bg-blue-600/30 blur-3xl"></div>
        <div class="absolute -left-20 bottom-[-180px] w-96 h-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
        <div class="relative px-7 sm:px-12 py-12 sm:py-16 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
            <div class="max-w-3xl"><p class="text-xs uppercase tracking-[.18em] font-extrabold text-blue-300">Siap mulai?</p><h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-white tracking-[-.035em]">Buat prestasimu lebih berarti.</h2><p class="text-sm sm:text-base text-slate-400 mt-3 max-w-2xl leading-7">Simpan setiap pencapaian, susun perjalananmu, dan bangun rekam jejak yang bisa kamu banggakan bersama E-Prestasi.</p></div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="bg-slate-50 border-t border-slate-100 section-pad scroll-mt-10">
    <div class="max-w-3xl mx-auto px-5 sm:px-8"><div class="text-center mb-12"><p class="text-xs font-extrabold tracking-[.18em] uppercase text-blue-600">FAQ</p><h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-[-.035em]">Pertanyaan yang sering muncul</h2></div>
        <div class="space-y-3">
            <details class="group bg-white border border-slate-100 rounded-2xl px-5 py-4 card-shadow"><summary class="list-none cursor-pointer flex items-center justify-between gap-4 font-bold text-sm">Siapa yang menggunakan E-Prestasi?<span class="plus text-slate-400 text-xl transition">+</span></summary><p class="text-sm text-slate-500 leading-6 mt-3 pr-8">Siswa mengajukan prestasi, kesiswaan memverifikasi, dan admin mengelola data sistem.</p></details>
            <details class="group bg-white border border-slate-100 rounded-2xl px-5 py-4 card-shadow"><summary class="list-none cursor-pointer flex items-center justify-between gap-4 font-bold text-sm">Bagaimana portofolio siswa dibagikan?<span class="plus text-slate-400 text-xl transition">+</span></summary><p class="text-sm text-slate-500 leading-6 mt-3 pr-8">Profil yang sudah lengkap dapat dibuka melalui QR Code tanpa perlu login.</p></details>
            <details class="group bg-white border border-slate-100 rounded-2xl px-5 py-4 card-shadow"><summary class="list-none cursor-pointer flex items-center justify-between gap-4 font-bold text-sm">Apakah prestasi langsung tampil setelah diajukan?<span class="plus text-slate-400 text-xl transition">+</span></summary><p class="text-sm text-slate-500 leading-6 mt-3 pr-8">Tidak. Prestasi perlu melewati proses verifikasi kesiswaan terlebih dahulu.</p></details>
        </div>
    </div>
</section>

<footer class="relative overflow-hidden bg-slate-950 text-slate-400">
    <div class="absolute -top-28 right-[8%] w-72 h-72 rounded-full bg-blue-600/15 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 left-[12%] w-80 h-80 rounded-full bg-cyan-500/10 blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-5 sm:px-8 pt-12 pb-6">
        <div class="grid gap-10 md:grid-cols-[1.5fr_.8fr_.8fr]">
            <div class="max-w-md">
                <p class="text-xl font-extrabold tracking-[-.03em] text-white">E-Prestasi</p>
                <p class="mt-3 text-sm leading-6 text-slate-400">
                    Sistem prestasi siswa yang membantu pencatatan pencapaian menjadi lebih rapi, terarah, dan mudah diakses.
                </p>
                <div class="mt-5 h-px w-20 bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                <p class="mt-4 text-xs text-slate-500">Prestasi hari ini, cerita untuk masa depan.</p>
            </div>

            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-300">Navigasi</p>
                <div class="mt-4 space-y-3 text-sm">
                    <a href="#tentang" class="block hover:text-white transition">Tentang</a>
                    <a href="#fitur" class="block hover:text-white transition">Fitur</a>
                    <a href="#alur" class="block hover:text-white transition">Cara Kerja</a>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-300">Bantuan</p>
                <div class="mt-4 space-y-3 text-sm">
                    <a href="#faq" class="block hover:text-white transition">FAQ</a>
                    <a href="{{ route('login') }}" class="block hover:text-white transition">Masuk</a>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-white/10 pt-5 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-500">
            <p>© {{ date('Y') }} E-Prestasi. Semua hak dilindungi.</p>
            <p>Sistem Informasi Prestasi Siswa</p>
        </div>
    </div>
</footer>

</body>
</html>
