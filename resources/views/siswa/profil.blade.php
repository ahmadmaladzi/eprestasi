<x-app-layout title="Profil Saya">
    <div class="max-w-2xl bg-white rounded-lg shadow-sm p-6">
        @if($siswa->qr_code)
            <div class="mb-6 p-3 bg-blue-50 border border-blue-200 rounded text-sm text-blue-800">
                Link portofolio publik kamu:
                <a href="{{ route('public.profil', $siswa->qr_code) }}" target="_blank" class="underline font-medium">
                    {{ url('/p/' . $siswa->qr_code) }}
                </a>
            </div>
        @else
            <div class="mb-6 p-3 bg-amber-50 border border-amber-200 rounded text-sm text-amber-800">
                Lengkapi & simpan profil kamu untuk otomatis membuat QR Code & link portofolio.
            </div>
        @endif

        <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Foto Profil</label>
                <input type="file" name="foto_profil" class="mt-1 block w-full text-sm">
                @error('foto_profil') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" class="mt-1 block w-full rounded border-gray-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan', $siswa->jurusan) }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $siswa->email) }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>

            <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700">Simpan Perubahan</button>
        </form>
    </div>
</x-app-layout>
