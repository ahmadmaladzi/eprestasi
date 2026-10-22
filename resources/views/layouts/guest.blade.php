<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Prestasi</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon-32.png') }}" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .float-slow { animation: float 6s ease-in-out infinite; }
        .dot-grid-light {
            background-image: radial-gradient(circle, rgba(47,111,237,0.08) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="min-h-screen bg-[#F5F7FB] text-[#0B1E38] antialiased">
    <div class="min-h-screen lg:flex">
        {{-- Panel visual desktop: foto sekolah tetap jadi identitas utama --}}
        <aside class="relative hidden overflow-hidden text-white lg:flex lg:w-[48%] lg:flex-col lg:justify-between"
               style="background-image: linear-gradient(180deg, rgba(11,30,56,0.62) 0%, rgba(11,30,56,0.20) 22%, rgba(11,30,56,0.28) 48%, rgba(11,30,56,0.88) 100%), url('{{ asset('images/smkn11.jpg') }}'); background-size: cover; background-position: center;">
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-[#2F6FED]/[0.16] via-transparent to-[#F97316]/[0.14]"></div>

            <div class="relative flex items-center justify-between gap-4 p-8 xl:p-10">
                <a href="{{ route('home') }}" class="group flex items-center gap-3">
                    <x-brand-logo :size="40" tone="light" subtitle="Sistem Informasi Prestasi" subtitle-class="text-white/60" class="transition group-hover:-translate-y-0.5" />
                </a>
                <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-[11px] font-semibold text-white/80 backdrop-blur-sm">SMKN 11 Bandung</span>
            </div>

            <div class="relative px-8 pb-10 xl:px-10 xl:pb-12">
                <div class="max-w-md">
                    <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-1.5 backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#4ADE80]"></span>
                        <span class="text-[11px] font-medium text-white/80">Layanan digital sekolah</span>
                    </div>

                    <h1 class="font-display text-3xl font-bold leading-[1.15] tracking-tight xl:text-[2.6rem]">Setiap prestasi,<br>tercatat rapi.</h1>
                    <p class="mt-4 max-w-sm text-sm leading-relaxed text-white/70">Satu tempat untuk mengajukan, memverifikasi, dan melihat rekap prestasi siswa SMKN 11 Bandung.</p>

                    <div class="mt-7 space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-white/20 bg-white/10 text-white">
                                <x-icon name="shield" :size="16" />
                            </span>
                            <div>
                                <p class="text-[12.5px] font-semibold text-white">Verifikasi terpusat</p>
                                <p class="mt-0.5 text-[11px] leading-relaxed text-white/60">Alur pengajuan yang jelas dan transparan.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-white/20 bg-white/10 text-white">
                                <x-icon name="trophy" :size="16" />
                            </span>
                            <div>
                                <p class="text-[12.5px] font-semibold text-white">Portofolio digital</p>
                                <p class="mt-0.5 text-[11px] leading-relaxed text-white/60">Prestasi tersimpan rapi dan mudah diakses.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-white/20 bg-white/10 text-white">
                                <x-icon name="chart" :size="16" />
                            </span>
                            <div>
                                <p class="text-[12.5px] font-semibold text-white">Statistik sekolah</p>
                                <p class="mt-0.5 text-[11px] leading-relaxed text-white/60">Rekap per tingkat, kategori, dan tahun ajaran.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center gap-2 text-[11px] font-medium text-white/60">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#4ADE80]"></span>
                        Sistem aktif untuk tahun ajaran berjalan
                    </div>
                </div>
            </div>

            <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-[#2F6FED] via-[#1B4FC4] to-[#F97316]"></div>
        </aside>

        {{-- Sisi form --}}
        <main class="relative flex min-h-screen flex-1 flex-col overflow-hidden">
            {{-- Banner foto ringkas untuk mobile/tablet --}}
            <div class="relative h-36 shrink-0 overflow-hidden lg:hidden"
                 style="background-image: linear-gradient(180deg, rgba(11,30,56,0.32) 0%, rgba(11,30,56,0.24) 45%, rgba(11,30,56,0.86) 100%), url('{{ asset('images/smkn11.jpg') }}'); background-size: cover; background-position: center;">
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-[#2F6FED]/[0.12] to-[#F97316]/[0.10]"></div>
                <div class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-3 p-4">
                    <a href="{{ route('home') }}" class="flex items-center text-white">
                        <x-brand-logo :size="32" tone="light" />
                    </a>
                    <span class="rounded-full border border-white/20 bg-white/10 px-2.5 py-1 text-[10px] font-semibold text-white/80 backdrop-blur-sm">SMKN 11 Bandung</span>
                </div>
            </div>

            <div class="relative flex flex-1 items-center justify-center px-4 py-8 sm:px-6 lg:px-10 lg:py-10">
                <div class="pointer-events-none absolute inset-0 dot-grid-light opacity-70"></div>
                <div class="pointer-events-none absolute -right-24 top-10 h-64 w-64 rounded-full bg-[#2F6FED]/[0.06] blur-3xl"></div>
                <div class="pointer-events-none absolute -left-24 bottom-0 h-56 w-56 rounded-full bg-[#F97316]/[0.06] blur-3xl"></div>

                <div class="relative w-full max-w-sm">
                    <div class="rounded-2xl border border-[#E8EDF5] bg-white p-6 shadow-xl shadow-[#0B1E38]/[0.06] sm:p-8">
                        {{ $slot }}
                    </div>

                    <div class="mt-5 flex flex-wrap items-center justify-center gap-x-1.5 gap-y-1 text-center text-[11px] text-[#94A3B8]">
                        <span>Butuh bantuan?</span>
                        <a href="{{ route('home') }}#faq" class="font-semibold text-[#2F6FED] transition hover:text-[#1B4FC4]">Lihat panduan &amp; FAQ</a>
                    </div>
                    <p class="mt-2 text-center text-[11px] text-[#CBD5E1]">&copy; {{ date('Y') }} SMKN 11 Bandung</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
