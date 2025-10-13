<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswasImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation
{
    use SkipsErrors;

    /**
     * Struktur header (case-insensitive) yang diharapkan:
     * nis | nama | kelas | jk | tanggal_lahir
     */
    public function model(array $row)
    {
        // Normalisasi kolom
        $nis   = (string)($row['nis'] ?? '');
        $nama  = (string)($row['nama'] ?? $row['nama_siswa'] ?? '');
        $kelas = (string)($row['kelas'] ?? '');
        $jk    = strtoupper((string)($row['jk'] ?? ''));
        $tgl   = (string)($row['tanggal_lahir'] ?? '');

        if (! $nis || ! $nama) {
            return null; // skip baris kosong
        }

        // Cari/buat kelas dari nama_kelas (opsional)
        $kelasModel = null;
        if ($kelas !== '') {
            $kelasModel = Kelas::firstOrCreate(
                ['nama_kelas' => $kelas],
                ['tingkat' => Str::upper(Str::before($kelas, ' '))]
            );
        }

        // upsert by NIS (unik)
        return Siswa::updateOrCreate(
            ['nis' => $nis],
            [
                'nama_siswa'    => $nama,
                'kelas_id'      => $kelasModel?->id,
                'jk'            => in_array($jk, ['L','P'], true) ? $jk : null,
                'tanggal_lahir' => $tgl ?: null,
            ]
        );
    }

    public function rules(): array
    {
        return [
            '*.nis'  => 'required',
            '*.nama' => 'required',
        ];
    }
}
