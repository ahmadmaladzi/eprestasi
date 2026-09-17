<x-app-layout title="Ganti Password">
    <div class="max-w-lg">
        <div class="bg-white rounded-2xl border border-slate-200 p-7">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-xl bg-[#2F6FED]/10 flex items-center justify-center shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="5" y="10" width="14" height="10" rx="2" stroke="#2F6FED" stroke-width="1.6"/><path d="M8 10V7a4 4 0 118 0v3" stroke="#2F6FED" stroke-width="1.6"/></svg>
                </div>
                <div>
                    <h2 class="font-semibold text-slate-800">Ganti Password</h2>
                    <p class="text-xs text-slate-400">Gunakan password baru yang kuat dan mudah diingat.</p>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4">
                    <p class="text-sm font-semibold text-red-700 mb-1.5">Gagal menyimpan, ada yang perlu diperbaiki:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 bg-[#22C55E]/10 border border-[#22C55E]/25 text-[#16803C] rounded-xl p-4 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('akunpassword.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password Saat Ini</label>
                    <input type="password" name="current_password"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password Baru</label>
                    <input type="password" name="password"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    <p class="text-xs text-slate-400 mt-1.5">Minimal 8 karakter.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                </div>

                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</x-app-layout>