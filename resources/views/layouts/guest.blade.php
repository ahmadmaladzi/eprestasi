<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Prestasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="text-slate-900 antialiased">
    <div class="min-h-screen flex">
        <div class="hidden md:flex md:w-2/5 bg-[#0F2540] text-white flex-col justify-between p-10">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M4 4H20V17L12 21L4 17V4Z" stroke="white" stroke-width="1.6" stroke-linejoin="round"/>
                        <path d="M9 11L11 13L15 9" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold">E-Prestasi</p>
            </div>
            <div>
                <p class="text-2xl font-bold leading-snug mb-3">Portal resmi pencatatan prestasi siswa.</p>
                <p class="text-sm text-white/60 leading-relaxed">Masuk menggunakan akun yang telah didaftarkan oleh admin sekolah.</p>
            </div>
            <p class="text-xs text-white/40">&copy; {{ date('Y') }} E-Prestasi</p>
        </div>

        <div class="flex-1 flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-sm">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>