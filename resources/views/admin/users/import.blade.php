<x-app-layout title="Import Akun dari Excel">
    <div class="max-w-2xl space-y-5">
        <div class="bg-white rounded-2xl border border-slate-200 p-7">
            <h2 class="font-semibold text-slate-800 mb-1">Import Akun Massal</h2>
            <p class="text-sm text-slate-500 mb-5">Upload file Excel/CSV berisi banyak akun siswa atau kesiswaan sekaligus.</p>

            <a href="{{ asset('templates/template-import-akun.xlsx') }}" download
               class="inline-flex items-center gap-2 text-sm font-semibold text-[#2F6FED] hover:text-[#1B4FC4] bg-[#2F6FED]/5 hover:bg-[#2F6FED]/10 px-4 py-2.5 rounded-xl transition mb-6">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M12 3V15M12 15L8 11M12 15L16 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 17V19C4 20.1 4.9 21 6 21H18C19.1 21 20 20.1 20 19V17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Download Template Excel
            </a>

            <div class="bg-slate-50 rounded-xl p-4 text-xs text-slate-500 mb-6 leading-relaxed">
                <p class="font-semibold text-slate-600 mb-1.5">Kolom yang dibutuhkan:</p>
                <p><strong>nama, email, role</strong> (wajib, isi <code>siswa</code> atau <code>kesiswaan</code>), <strong>password</strong> (opsional, default: password123)</p>
                <p class="mt-1">Khusus <strong>siswa</strong>: nis, kelas, jurusan wajib diisi.</p>
                <p class="mt-1">Khusus <strong>kesiswaan</strong>: nip wajib diisi.</p>
                <p class="mt-1.5 text-[#2F6FED]">💡 Template sudah dilengkapi sheet "Petunjuk Pengisian" dan dropdown pilihan role.</p>
            </div>

            @if(session('gagalImport') && count(session('gagalImport')) > 0)
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-5">
                    <p class="text-xs font-semibold text-red-700 mb-2">Baris yang gagal diimpor:</p>
                    <ul class="text-xs text-red-600 space-y-1">
                        @foreach(session('gagalImport') as $g)
                            <li>Baris {{ $g['baris'] }}: {{ $g['pesan'] }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">File Excel/CSV (.xlsx, .xls, .csv — max 5MB)</label>
                    <input type="file" name="file" required
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#2F6FED]/10 file:text-[#2F6FED] hover:file:bg-[#2F6FED]/20 transition">
                    @error('file') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-3">
                    <button class="bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                        Import Sekarang
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>