<x-app-layout title="Tambah User">
    <div class="max-w-2xl bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.users.store') }}" x-data="{ role: 'siswa' }" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" x-model="role" class="mt-1 block w-full rounded border-gray-300">
                    <option value="siswa">Siswa</option>
                    <option value="kesiswaan">Kesiswaan</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="mt-1 block w-full rounded border-gray-300">
                @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded border-gray-300">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="mt-1 block w-full rounded border-gray-300">
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div x-show="role === 'siswa'" class="space-y-4 border-t pt-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIS</label>
                        <input type="text" name="nis" value="{{ old('nis') }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas') }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>
                </div>
            </div>

            <div x-show="role === 'kesiswaan'" class="space-y-4 border-t pt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip') }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="mt-1 block w-full rounded border-gray-300">
            </div>

            <div class="flex gap-3">
                <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
