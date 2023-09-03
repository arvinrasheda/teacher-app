<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Kriteria;
use App\NilaiGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $list = Guru::all();
        return view('guru.index', compact('list'));
    }
    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        try {
            DB::beginTransaction();

            $model = new Guru();
            $model->nip = $input['nip'];
            $model->nama = $input['nama'];
            $model->keterangan = $input['keterangan'];
            $model->save();

            $listKriteria = Kriteria::all();

            $save = [];

            foreach ($listKriteria as $kriteria) {
                $save[] = [
                    'nip_guru' => $input['nip'],
                    'kode_kriteria' => $kriteria->kode_kriteria,
                    'id_nilai_kriteria' => null,
                    'created_at' => now()
                ];
            }

            NilaiGuru::insert($save);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->withInput()->with("errormessage", $exception->getMessage());
        }

        return redirect()->route('guru.index')->with('successmessage', 'Data berhasil disimpan!');
    }

    public function edit($id, Request $request) {
        $data = Guru::find($id);
        return view('guru.edit', compact('data'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->except('_token');

            $model = Guru::find($input['id']);

            $nilaiGuru = NilaiGuru::where('nip_guru', $model->nip)->first();
            $nilaiGuru->nip_guru = $input['nip'];
            $nilaiGuru->save();
            $model->nip = $input['nip'];
            $model->nama = $input['nama'];
            $model->keterangan = $input['keterangan'];
            $model->save();
            DB::commit();

            return redirect()->route('guru.index')->with('successmessage', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle any errors that occur during deletion
            return redirect()->route('guru.index')->with('errormessage', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $guru = Guru::findOrFail($id);

            NilaiGuru::where('nip_guru', $guru->nip)->delete();

            $guru->delete();

            // Redirect back with a success message
            return redirect()->route('guru.index')->with('successmessage', 'Guru deleted successfully');
        } catch (\Exception $e) {
            // Handle any errors that occur during deletion
            return redirect()->route('guru.index')->with('errormessage', 'Failed to delete guru');
        }
    }
}
