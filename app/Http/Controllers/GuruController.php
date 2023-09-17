<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Kriteria;
use App\NilaiGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    /**
     * @throws \Exception
     */
    public static function validationNip($nip) {
        $existNip = Guru::where('nip', $nip)->get()->toArray();

        if (count($existNip) > 0) {
            throw new \Exception('NIP yang sama tidak bisa di proses');
        }
    }

    /**
     * @throws \Exception
     */
    public static function validationName($name) {
        $existName = Guru::where('nama', $name)->get()->toArray();
        if (count($existName) > 0) {
            throw new \Exception('Nama yang sama tidak bisa di proses');
        }
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        try {
            $validator = Validator::make($request->all(), [
                'nip' => 'required|numeric|unique:guru,nip',
                'nama' => 'required|string|max:255|unique:guru,nama',
                'keterangan' => 'required|string',
                'posisi' => 'required|string',
                'masa_bakti' => 'required|numeric',
                'jenis_kelamin' => 'required|string',
                'pendidikan' => 'required|string',
            ]);

            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->back()->with("errormessage", $errorMessages);
            }

            DB::beginTransaction();

            $model = new Guru();
            $model->nip = $input['nip'];
            $model->nama = $input['nama'];
            $model->keterangan = $input['keterangan'];
            $model->jenis_kelamin = $input['jenis_kelamin'];
            $model->posisi = $input['posisi'];
            $model->masa_bakti = $input['masa_bakti'];
            $model->pendidikan = $input['pendidikan'];
            $model->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with("errormessage", $exception->getMessage());
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
            $validator = Validator::make($request->all(), [
                'nip' => 'required|numeric',
                'nama' => 'required|string',
                'keterangan' => 'required|string',
                'posisi' => 'required|string',
                'masa_bakti' => 'required|numeric',
                'jenis_kelamin' => 'required|string',
                'pendidikan' => 'required|string',
            ]);

            if ($validator->fails()) {
                $errorMessages = implode(' ', $validator->errors()->all());
                return redirect()->back()->with("errormessage", $errorMessages);
            }


            $model = Guru::find($input['id']);
            if ($input['nip'] != $model->nip) {
                self::validationNip($input['nip']);
            }
            if ($input['nama'] != $model->nama) {
                self::validationName($input['nama']);
            }

            $itemsNilaiGuru = NilaiGuru::where('nip_guru', $model->nip)->get();
            foreach ($itemsNilaiGuru as $item) {
                $nilaiGuru = NilaiGuru::find($item->id);
                $nilaiGuru->nip_guru = $input['nip'];
                $nilaiGuru->save();
            }
            $model->nip = $input['nip'];
            $model->nama = $input['nama'];
            $model->keterangan = $input['keterangan'];
            $model->jenis_kelamin = $input['jenis_kelamin'];
            $model->posisi = $input['posisi'];
            $model->masa_bakti = $input['masa_bakti'];
            $model->pendidikan = $input['pendidikan'];
            $model->save();
            DB::commit();

            return redirect()->route('guru.index')->with('successmessage', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle any errors that occur during deletion
            return redirect()->back()->with('errormessage', $e->getMessage());
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
