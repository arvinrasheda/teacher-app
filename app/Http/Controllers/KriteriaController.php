<?php

namespace App\Http\Controllers;

use App\Kriteria;
use Illuminate\Http\Request;
class KriteriaController extends Controller
{
    public function index()
    {
        $list = Kriteria::select('*')->orderBy('kode_kriteria')->get();
        return view('kriteria.index', compact('list'));
    }
    public function create()
    {
        return redirect()->to('master/kriteria')->with("successmessage", "Data berhasil disimpan!");
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        $model = new Kriteria();
        $model->kode_kriteria = $input['kode_kriteria'];
        $model->nama_kriteria = $input['nama_kriteria'];
        $model->attribute = $input['attribute'];
        $model->bobot = $input['bobot'];
        $model->save();

        return redirect()->to('master/kriteria')->with("successmessage", "Data berhasil disimpan!");
    }
}
