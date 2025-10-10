<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JenisBimbinganRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check() && auth()->user()->isAdmin(); }

    public function rules(): array
    {
        $id = $this->route('jenis')?->id;

        return [
            'kode'       => 'required|string|max:50|unique:jenis_bimbingans,kode,'.($id ?? 'NULL').',id',
            'nama_jenis' => 'required|string|max:100',
            'tipe'       => 'required|in:positif,negatif',
            'poin'       => 'required|integer',
        ];
    }
}
