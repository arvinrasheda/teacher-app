<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Kriteria;
use App\NilaiGuru;
use App\NilaiKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiGuruController extends Controller
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

        return view('nilai_guru.index', compact('listKriteria', 'list'));
    }

    public function edit($nip)
    {
        $listKriteria = Kriteria::select('*')->orderBy('kode_kriteria')->get()->toArray();
        $guru = Guru::where('nip', $nip)->first();
        $result = [];
        foreach ($listKriteria as $kriteria) {
            $item = NilaiKriteria::where('kode_kriteria', $kriteria['kode_kriteria'])->get()->toArray();
            $kriteria['items'] = $item;
            $result[] = $kriteria;
        }

        $listKriteria = $result;
        return view('nilai_guru.edit', compact('listKriteria', 'listKriteria', 'nip', 'guru'));
    }

    public function store($nip, Request $request)
    {
        $input = $request->except('_token');

        foreach ($input as $kode_kriteria => $id_nilai_kriteria) {
            $nilaiGuru = NilaiGuru::where('nip_guru', $nip)->where('kode_kriteria', $kode_kriteria)->first();
            $nilaiGuru->id_nilai_kriteria = $id_nilai_kriteria;
            $nilaiGuru->save();
        }

        return redirect()->to('nilai-guru')->with("successmessage", "Data berhasil disimpan!");
    }
}
