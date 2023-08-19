<?php

namespace App\Services;

use App\NilaiGuru;
use App\NilaiKriteria;

class GuruServices
{
    public static function getItemNilai($nip, $kode_kriteria)
    {
        $nilaiGuru = NilaiGuru::where('nip_guru', $nip)->where('kode_kriteria', $kode_kriteria)->first();
        if ($nilaiGuru) {
            if ($nilaiGuru->id_nilai_kriteria) {
                $nilaiKriteria = NilaiKriteria::find($nilaiGuru->id_nilai_kriteria);
                return $nilaiKriteria->keterangan;
            }
        }

        return 'belum dinilai';
    }

}
