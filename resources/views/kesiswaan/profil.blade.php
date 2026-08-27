<x-app-layout title="Profil Saya">
    <div class="max-w-2xl bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('kesiswaan.profil.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">NIP</label>
                <input type="text" value="{{ $kesiswaan->nip }}" disabled class="mt-1 block w-full rounded border-gray-300 bg-gray-100 text-gray-500">
                <p class="text-xs text-gray-400 mt-1">NIP tidak dapat diubah sendiri. Hubungi admin jika perlu diperbarui.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $kesiswaan->nama) }}" class="mt-1 block w-full rounded border-gray-300">
                @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $kesiswaan->jabatan) }}" class="mt-1 block w-full rounded border-gray-300">
                @error('jabatan') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $kesiswaan->email) }}" class="mt-1 block w-full rounded border-gray-300">
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $kesiswaan->no_hp) }}" class="mt-1 block w-full rounded border-gray-300">
                    @error('no_hp') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700">Simpan Perubahan</button>
        </form>
    </div>
</x-app-layout>
