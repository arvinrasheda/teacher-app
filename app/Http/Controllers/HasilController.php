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
                guru.id,
                nilai_guru.nip_guru,
                guru.nama AS nama_guru
            FROM
                "nilai_guru"
                LEFT JOIN guru ON guru.nip = nilai_guru.nip_guru
            GROUP BY
                guru.nama,
                nilai_guru.nip_guru,
                guru.id
        ');

        return view('hasil.index', compact('listKriteria', 'list'));
    }
}
