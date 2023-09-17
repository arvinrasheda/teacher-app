<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Kriteria;
use App\NilaiGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $countGuru = count(Guru::all());
        $listKriteria = Kriteria::select('*')->orderBy('kode_kriteria')->get();
        $list = DB::select('
            SELECT
                guru.ID,
                nilai_guru.nip_guru,
                guru.nama AS nama_guru
            FROM
                nilai_guru
                LEFT JOIN guru ON guru.nip = nilai_guru.nip_guru
            WHERE
                nilai_guru.id_nilai_kriteria IS NOT NULL
            GROUP BY
                guru.nama,
                nilai_guru.nip_guru,
                guru.ID
        ');
        $posisiSubject = Guru::where('posisi', 'SUBJECT')->get()->count();
        $posisiWaliKelas = Guru::where('posisi', 'WALI_KELAS')->get()->count();

        // Data dengan masa bakti lebih dari 10 tahun
        $dataMasaBaktiLebihDari10Tahun = DB::table('guru')
            ->where('masa_bakti', '>', 10)
            ->get()->count();

        // Data dengan masa bakti kurang dari 10 tahun tetapi lebih dari 5 tahun
        $dataMasaBaktiKurangDari10Tahun = DB::table('guru')
            ->where('masa_bakti', '>', 5)
            ->where('masa_bakti', '<=', 10)
            ->get()->count();

        // Data dengan masa bakti kurang dari 5 tahun
        $dataMasaBaktiKurangDari5Tahun = DB::table('guru')
            ->where('masa_bakti', '<', 5)
            ->get()->count();

        $maleCount = Guru::where('jenis_kelamin', 'L')->count();
        $femaleCount = Guru::where('jenis_kelamin', 'P')->count();
        // Hitung jumlah guru dengan tingkat pendidikan S1
        $s1Count = Guru::where('pendidikan', 'S1')->count();

        // Hitung jumlah guru dengan tingkat pendidikan S2
        $s2Count = Guru::where('pendidikan', 'S2')->count();

        // Hitung jumlah guru dengan tingkat pendidikan S3
        $s3Count = Guru::where('pendidikan', 'S3')->count();

        return view('dashboard', compact(
            'countGuru',
            'listKriteria',
            'list',
            'dataMasaBaktiKurangDari5Tahun',
            'dataMasaBaktiKurangDari10Tahun',
            'dataMasaBaktiLebihDari10Tahun',
            'maleCount',
            'femaleCount',
            's1Count',
            's2Count',
            's3Count',
            'posisiSubject',
            'posisiWaliKelas'
        ));
    }
}
