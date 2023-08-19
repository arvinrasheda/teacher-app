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

        return redirect()->to('master/kriteria');
    }
}
