<?php

namespace App\Http\Controllers;

use App\Kriteria;
use App\NilaiKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiKriteriaController extends Controller
{
    public function index()
    {
        $list = DB::select('SELECT * FROM nilai_kriteria LEFT JOIN kriteria ON kriteria.kode_kriteria = nilai_kriteria.kode_kriteria');
        return view('nilai_kriteria.index', compact('list'));
    }
    public function create()
    {
        $kriteria = Kriteria::select('*')->orderBy('kode_kriteria')->get();
        return view('nilai_kriteria.create', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        $model = new NilaiKriteria();
        $model->kode_kriteria = $input['kode_kriteria'];
        $model->keterangan = $input['keterangan'];
        $model->nilai = $input['nilai'];
        $model->save();

        return redirect()->to('master/nilai-kriteria');
    }
}
