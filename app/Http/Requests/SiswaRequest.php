<?php
// app/Http/Requests/SiswaRequest.php
class SiswaRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('siswa')?->id;
        return [
            'nis'   => ['required','string','max:30', Rule::unique('siswa','nis')->ignore($id)],
            'nama_siswa' => ['required','string','max:150'],
            'kelas_id'   => ['required','exists:kelas,id'],
            'jk'         => ['nullable','in:L,P'],
            'tanggal_lahir' => ['nullable','date'],
        ];
    }
}   
