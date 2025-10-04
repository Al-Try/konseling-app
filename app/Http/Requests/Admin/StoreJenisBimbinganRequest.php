<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisBimbinganRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->isAdmin() ?? false; }

    public function rules(): array
    {
        return [
            'nama_jenis' => ['required','string','max:100','unique:jenis_bimbingans,nama_jenis'],
            'tipe'       => ['required','in:positif,negatif'],
            'poin'       => ['required','integer','between:-100,100'],
        ];
    }
}
