<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>403 - Akses Ditolak</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <p class="text-6xl font-bold text-slate-800">403</p>
        <p class="text-gray-600 mt-2">Kamu tidak punya akses ke halaman ini.</p>
        <a href="{{ url('/') }}" class="inline-block mt-4 text-sm text-blue-600 hover:underline">&larr; Kembali ke Beranda</a>
    </div>
</body>
</html>
