<?php

namespace App\Services;

use App\Kriteria;
use App\NilaiGuru;
use App\NilaiKriteria;

class GuruServices
{
    /**
     * @param $nip
     * @param $kode_kriteria
     * @return string
     */
    public static function getItemKeterangan($nip, $kode_kriteria, $tahun_ajaran): string
    {
        $nilaiGuru = NilaiGuru::where('nip_guru', $nip)
            ->where('kode_kriteria', $kode_kriteria)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();
        if ($nilaiGuru) {
            if ($nilaiGuru->id_nilai_kriteria) {
                $nilaiKriteria = NilaiKriteria::find($nilaiGuru->id_nilai_kriteria);
                return $nilaiKriteria->keterangan;
            }
        }

        return 'belum dinilai';
    }

    /**
     * @param $nip
     * @param $kode_kriteria
     * @return int
     */
    public static function getItemNilai($nip, $kode_kriteria, $tahun_ajaran): int
    {
        $nilaiGuru = NilaiGuru::where('nip_guru', $nip)
            ->where('kode_kriteria', $kode_kriteria)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();
        if ($nilaiGuru) {
            if ($nilaiGuru->id_nilai_kriteria) {
                $nilaiKriteria = NilaiKriteria::find($nilaiGuru->id_nilai_kriteria);
                return $nilaiKriteria->nilai;
            }
        }

        return 0;
    }

    /**
     * @param $nip
     * @param $kode_kriteria
     * @return float|int
     */
    public static function getNormalisasi($nip, $kode_kriteria, $tahun_ajaran)
    {
        $nilaiGuru = NilaiGuru::where('nip_guru', $nip)
            ->where('kode_kriteria', $kode_kriteria)
            ->where('tahun_ajaran', $tahun_ajaran)
            ->first();
        $allNilai = NilaiGuru::where('kode_kriteria', $kode_kriteria)
            ->whereNotNull('id_nilai_kriteria')
            ->where('tahun_ajaran', $tahun_ajaran)
            ->get()
            ->toArray();

        $nilai = [];
        if($nilaiGuru && count($allNilai) > 0) {
            $nilaiRowNip = NilaiKriteria::find($nilaiGuru->id_nilai_kriteria);
            foreach ($allNilai as $item) {
                $nilaiKriteria = NilaiKriteria::find($item['id_nilai_kriteria']);
                $nilai[] = $nilaiKriteria->nilai;
            }

            return floatval($nilaiRowNip->nilai) / floatval(max($nilai));
        }

        return 0.0;
    }

    /**
     * @param $nip
     * @param $kode_kriteria
     * @param $normalisasi
     * @return float|int
     */
    public static function getPerangkingan($nip, $kode_kriteria, $normalisasi)
    {
        $model = Kriteria::where('kode_kriteria', $kode_kriteria)->first();
        $bobot = $model->bobot / 100;
        return floatval($bobot) * floatval($normalisasi);
    }

}
