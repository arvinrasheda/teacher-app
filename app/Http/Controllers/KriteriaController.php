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
        return view('kriteria.create');
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

    public function edit($id, Request $request) {
        $data = Kriteria::find($id);
        return view('kriteria.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $input = $request->except('_token');

        $model = Kriteria::find($input['id']);
        $model->kode_kriteria = $input['kode_kriteria'];
        $model->nama_kriteria = $input['nama_kriteria'];
        $model->attribute = $input['attribute'];
        $model->bobot = $input['bobot'];
        $model->save();

        return redirect()->to('master/kriteria')->with("successmessage", "Data berhasil disimpan!");
    }

    public function destroy($id)
    {
        try {
            // Find the kriteria by ID
            $kriteria = Kriteria::findOrFail($id);

            // Delete the kriteria
            $kriteria->delete();

            // Redirect back with a success message
            return redirect()->route('kriteria.index')->with('successmessage', 'Kriteria deleted successfully');
        } catch (\Exception $e) {
            // Handle any errors that occur during deletion
            return redirect()->route('kriteria.index')->with('errormessage', 'Failed to delete kriteria');
        }
    }
}
