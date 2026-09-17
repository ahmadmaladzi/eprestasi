<x-app-layout title="Tambah User">
    <div class="max-w-xl" x-data="{ role: 'siswa' }">
        <div class="bg-white rounded-2xl border border-slate-200 p-7">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Role</label>
                    <div class="grid grid-cols-3 gap-2.5">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="siswa" x-model="role" class="peer sr-only" checked>
                            <div class="text-center py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-500 peer-checked:bg-[#2F6FED]/10 peer-checked:border-[#2F6FED] peer-checked:text-[#2F6FED] transition">Siswa</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="kesiswaan" x-model="role" class="peer sr-only">
                            <div class="text-center py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-500 peer-checked:bg-[#2F6FED]/10 peer-checked:border-[#2F6FED] peer-checked:text-[#2F6FED] transition">Kesiswaan</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="admin" x-model="role" class="peer sr-only">
                            <div class="text-center py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-500 peer-checked:bg-[#2F6FED]/10 peer-checked:border-[#2F6FED] peer-checked:text-[#2F6FED] transition">Admin</div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    @error('nama') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                        @error('email') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password</label>
                        <input type="text" name="password" placeholder="Kosongkan untuk default: password123"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                        @error('password') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div x-show="role === 'siswa'" x-cloak class="border-t border-slate-100 pt-5 space-y-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Data Siswa</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">NIS</label>
                            <input type="text" name="nis" value="{{ old('nis') }}"
                                   class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            @error('nis') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kelas</label>
                            <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XII RPL 1"
                                   class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            @error('kelas') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jurusan</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                        @error('jurusan') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div x-show="role === 'kesiswaan'" x-cloak class="border-t border-slate-100 pt-5 space-y-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Data Kesiswaan</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip') }}"
                                   class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            @error('nip') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Wakasek Kesiswaan"
                                   class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            @error('jabatan') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                        Buat Akun
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>