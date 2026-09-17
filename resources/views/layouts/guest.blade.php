<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Prestasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .float-slow { animation: float 6s ease-in-out infinite; }
        .dot-grid-light {
            background-image: radial-gradient(circle, rgba(47,111,237,0.08) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="text-slate-900 antialiased">
    <div class="min-h-screen flex">
        <div class="hidden md:flex md:w-1/2 lg:w-[48%] relative overflow-hidden text-white flex-col justify-between p-12"
             style="background-image: linear-gradient(180deg, rgba(11,30,56,0.55) 0%, rgba(11,30,56,0.55) 40%, rgba(11,30,56,0.92) 100%), url('{{ asset('images/smkn11.jpg') }}'); background-size: cover; background-position: center;">

            <div class="flex items-center justify-between relative">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] flex items-center justify-center shadow-lg shadow-[#2F6FED]/40">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M4 4H20V17L12 21L4 17V4Z" stroke="white" stroke-width="1.7" stroke-linejoin="round"/>
                            <path d="M9 11L11 13L15 9" stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">E-Prestasi</p>
                </div>
                <span class="text-[11px] font-semibold text-white/70 bg-white/10 border border-white/15 px-3 py-1.5 rounded-full backdrop-blur-sm">SMKN 11 Bandung</span>
            </div>

            <div class="flex-1"></div>

            <div class="relative">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 rounded-full px-3.5 py-1.5 mb-5 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4ADE80]"></span>
                    <span class="text-xs font-medium text-white/80">Layanan digital sekolah</span>
                </div>
                <p class="text-2xl font-extrabold leading-snug mb-2">Portal resmi pencatatan prestasi siswa.</p>
                <p class="text-sm text-white/60 leading-relaxed">Masuk menggunakan akun yang telah didaftarkan oleh admin sekolah.</p>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center px-6 py-12 bg-[#FAFBFF] relative overflow-hidden">
            <div class="absolute inset-0 dot-grid-light pointer-events-none"></div>
            <div class="absolute -top-32 -right-32 w-72 h-72 bg-[#2F6FED]/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="w-full max-w-sm relative">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/40 p-8">
                    {{ $slot }}
                </div>
                <p class="text-center text-xs text-slate-400 mt-6">Butuh bantuan masuk? Hubungi admin sekolah kamu.</p>
            </div>
        </div>
    </div>
</body>
</html>