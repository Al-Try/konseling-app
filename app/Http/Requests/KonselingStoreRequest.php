<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KonselingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'siswa_id'  => ['required','exists:siswas,id'],
            'jenis_id'  => ['required','exists:jenis_bimbingans,id'],
            'tanggal'   => ['required','date'],
            'jam'       => ['nullable','date_format:H:i'],
            'catatan'   => ['nullable','string','max:1000'],
        ];
    }

}
