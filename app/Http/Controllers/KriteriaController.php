<?php

namespace App\Http\Controllers;

use App\Kriteria;
use App\NilaiGuru;
use App\NilaiKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        try {
            $getTotal = DB::select("
                SELECT SUM(bobot) as total_nilai
                FROM public.kriteria
            ");

            $sumTotal = $getTotal->total_nilai + $input['bobot'];

            if ($sumTotal != 100 ) {
                throw new \Exception('Total Bobot Tidak Boleh Lebih / Kurang Dari 100');
            }

            $model = new Kriteria();
            $model->kode_kriteria = $input['kode_kriteria'];
            $model->nama_kriteria = $input['nama_kriteria'];
            $model->attribute = $input['attribute'];
            $model->bobot = $input['bobot'];
            $model->save();

            foreach (['Sangat Baik', 'Baik', 'Cukup Baik', 'Kurang Baik'] as $keterangan) {
                $model = new NilaiKriteria();
                $model->kode_kriteria = $input['kode_kriteria'];
                $model->keterangan = $keterangan;
                $model->nilai = 0;
                $model->save();
            }

            return redirect()->route('kriteria.index')->with('successmessage', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->route('kriteria.index')->with('errormessage', $e->getMessage());
        }
    }

    public function edit($id, Request $request) {
        $data = Kriteria::find($id);
        return view('kriteria.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $input = $request->except('_token');
        try {
            $id = $input['id'];

            $getTotal = DB::select("
                SELECT SUM(bobot) as total_nilai
                FROM public.kriteria
                WHERE id <> $id;
            ");

            $sumTotal = $getTotal[0]->total_nilai + $input['bobot'];

            if ($sumTotal > 100) {
                throw new \Exception('Total Bobot Tidak Boleh Lebih Dari 100');
            }


            $model = Kriteria::find($input['id']);
            $model->kode_kriteria = $input['kode_kriteria'];
            $model->nama_kriteria = $input['nama_kriteria'];
            $model->attribute = $input['attribute'];
            $model->bobot = $input['bobot'];
            $model->save();

            return redirect()->route('kriteria.index')->with('successmessage', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            // Handle any errors that occur during deletion
            return redirect()->route('kriteria.index')->with('errormessage', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Find the kriteria by ID
            $kriteria = Kriteria::findOrFail($id);

            $nilaiKriteria = NilaiKriteria::where('kode_kriteria', $kriteria->kode_kriteria)->get();

            $nilaiGuru = NilaiGuru::where('kode_kriteria', $kriteria->kode_kriteria)->get()->toArray();

            if (count($nilaiGuru) > 0) {
                throw new \Exception("Tidak Bisa hapus kriteria karena sudah digunakan untuk menilai");
            }

            $nilaiKriteria->delete();

            // Delete the kriteria
            $kriteria->delete();

            // Redirect back with a success message
            return redirect()->route('kriteria.index')->with('successmessage', 'Kriteria deleted successfully');
        } catch (\Exception $e) {
            // Handle any errors that occur during deletion
            return redirect()->route('kriteria.index')->with('errormessage', $e->getMessage());
        }
    }
}
