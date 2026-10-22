<x-guest-layout>
    <div class="text-center mb-7">
        <h1 class="font-display text-2xl font-semibold">Buat akun siswa</h1>
        <p class="text-sm text-[#1B2340]/50 mt-1">Mulai dokumentasikan prestasimu</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="nama" :value="__('Nama Lengkap')" />
            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <x-input-label for="nis" :value="__('NIS')" />
                <x-text-input id="nis" class="block mt-1 w-full" type="text" name="nis" :value="old('nis')" required />
                <x-input-error :messages="$errors->get('nis')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="kelas" :value="__('Kelas')" />
                <x-text-input id="kelas" class="block mt-1 w-full" type="text" name="kelas" :value="old('kelas')" required placeholder="XI" />
                <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="jurusan" :value="__('Jurusan')" />
                <x-text-input id="jurusan" class="block mt-1 w-full" type="text" name="jurusan" :value="old('jurusan')" required placeholder="RPL" />
                <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm text-[#1B2340]/60 hover:text-[#1B2340] underline" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <button type="submit" class="bg-[#1B2340] text-white px-5 py-2.5 rounded-md text-sm font-medium hover:bg-[#262f52] transition">
                {{ __('Daftar') }}
            </button>
        </div>

        <p class="text-xs text-[#1B2340]/40 pt-5 border-t border-[#1B2340]/10 mt-6 text-center">
            Pendaftaran mandiri hanya untuk akun siswa. Akun kesiswaan/admin dibuatkan oleh admin sekolah.
        </p>
    </form>
</x-guest-layout>