<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_prestasi' => ['required', 'string', 'max:255'],
            'penyelenggara' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'in:Sekolah,Kabupaten/Kota,Provinsi,Nasional,Internasional'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'asal' => ['nullable', 'in:Dalam Negeri,Luar Negeri'],
            'jenis_penyelenggara' => ['nullable', 'in:Kementerian,Non Kementerian'],
            'terhubung_puspresnas' => ['nullable', 'boolean'],
            'sertifikat' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'sertifikat_deskripsi' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'caption' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_prestasi.required' => 'Nama prestasi wajib diisi.',
            'penyelenggara.required' => 'Nama penyelenggara wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
            'sertifikat.mimes' => 'Sertifikat harus berupa PDF, JPG, atau PNG.',
            'sertifikat.max' => 'Ukuran sertifikat maksimal 2MB.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}