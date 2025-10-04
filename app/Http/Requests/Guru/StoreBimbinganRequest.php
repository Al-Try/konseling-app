<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class StoreBimbinganRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->isGuruWali() ?? false; }

    public function rules(): array
    {
        return [
            'tanggal'   => ['required','date'],
            'siswa_id'  => ['required','exists:siswas,id'],
            'jenis_id'  => ['required','exists:jenis_bimbingans,id'],
            'catatan'   => ['nullable','string','max:1000'],
        ];
    }
}
