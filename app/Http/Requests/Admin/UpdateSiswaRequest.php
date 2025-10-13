<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('siswa');
        return [
            'nis'           => 'required|string|max:30|unique:siswas,nis,'.$id,
            'nama_siswa'    => 'required|string|max:150',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'jk'            => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
        ];
    }

    public function attributes(): array
    {
        return ['nama_siswa' => 'nama'];
    }
}
