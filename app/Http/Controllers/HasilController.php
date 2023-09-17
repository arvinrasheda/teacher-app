<?php

namespace App\Http\Controllers;

use App\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilController extends Controller
{
    public function index()
    {
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

        return view('hasil.index', compact('listKriteria', 'list'));
    }
}
