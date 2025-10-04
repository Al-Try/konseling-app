<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJenisBimbinganRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->isAdmin() ?? false; }

    public function rules(): array
    {
        $id = $this->route('jeni')?->id ?? $this->route('jenis')?->id; // sesuai parameter
        return [
            'nama_jenis' => ['required','string','max:100',"unique:jenis_bimbingans,nama_jenis,{$id}"],
            'tipe'       => ['required','in:positif,negatif'],
            'poin'       => ['required','integer','between:-100,100'],
        ];
    }
}
