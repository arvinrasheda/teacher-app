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
    public function index(Request $request)
    {
        $listKriteria = Kriteria::select('*')->orderBy('kode_kriteria')->get();
        $tahunAjaran = $request->get('tahun_ajaran') ?: date('Y');

        $tahunAjaranList = [
            '2022' => 'Tahun Ajaran 2021/2022',
            '2023' => 'Tahun Ajaran 2022/2023',
            '2024' => 'Tahun Ajaran 2023/2024'
        ];
        $guruList = Guru::all();
        $list = DB::select('
            SELECT
                guru.id,
                nilai_guru.nip_guru,
                guru.nama AS nama_guru,
                nilai_guru.tahun_ajaran
            FROM
                "nilai_guru"
                LEFT JOIN guru ON guru.nip = nilai_guru.nip_guru
            WHERE nilai_guru.tahun_ajaran = :tahunAjaran OR nilai_guru.tahun_ajaran IS NULL
            GROUP BY
                guru.nama,
                nilai_guru.nip_guru,
                nilai_guru.tahun_ajaran,
                guru.id
        ', ['tahunAjaran' => $tahunAjaran]);

        return view('nilai_guru.index', compact('listKriteria', 'list', 'tahunAjaran', 'tahunAjaranList', 'guruList'));
    }

    public function addFromTahunAjaran(Request $request) {
        $input = $request->except('_token');
        try {

            $isExist = NilaiGuru::where('nip_guru', $input['nip'])->where('tahun_ajaran', $input['tahun_ajaran'])->first();
            if ($isExist) {
                throw new \Exception('Data Guru Dengan Tahun ajaran tersebut telah tersedia.');
            }

            DB::beginTransaction();

            $listKriteria = Kriteria::all();

            $save = [];

            foreach ($listKriteria as $kriteria) {
                $save[] = [
                    'nip_guru' => $input['nip'],
                    'kode_kriteria' => $kriteria->kode_kriteria,
                    'id_nilai_kriteria' => null,
                    'tahun_ajaran' => $input['tahun_ajaran'],
                    'created_at' => now()
                ];
            }

            NilaiGuru::insert($save);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with("errormessage", $exception->getMessage());
        }

        return redirect()->route('nilai_guru.index')->with('successmessage', 'Data berhasil disimpan!');
    }

    public function edit($nip, Request $request)
    {
        $listKriteria = Kriteria::select('*')->orderBy('kode_kriteria')->get()->toArray();
        $guru = Guru::where('nip', $nip)->first();
        $result = [];
        $tahunAjaran = $request->get('tahun_ajaran');

        $tahunAjaranList = [
            '2022' => 'Tahun Ajaran 2021/2022',
            '2023' => 'Tahun Ajaran 2022/2023',
            '2024' => 'Tahun Ajaran 2023/2024'
        ];
        foreach ($listKriteria as $kriteria) {
            $nilaiGuru = NilaiGuru::where('nip_guru', $nip)->where('tahun_ajaran', $tahunAjaran)->where('kode_kriteria', $kriteria['kode_kriteria'])->first();
            $items = NilaiKriteria::where('kode_kriteria', $kriteria['kode_kriteria'])->get()->toArray();
            $resItems = [];
            foreach ($items as $item) {
                $item['selected'] = $nilaiGuru->id_nilai_kriteria == $item['id'];
                $resItems[] = $item;
            }

            $kriteria['items'] = $resItems;
            $result[] = $kriteria;
        }

        $listKriteria = $result;
        return view('nilai_guru.edit', compact('listKriteria', 'listKriteria', 'nip', 'guru', 'tahunAjaranList', 'tahunAjaran'));
    }

    public function store($nip, Request $request)
    {
        $input = $request->except('_token');

        $tahunAjaran = $input['tahun_ajaran'];
        unset($input['tahun_ajaran']);
        foreach ($input as $kode_kriteria => $id_nilai_kriteria) {
            $nilaiGuru = NilaiGuru::where('nip_guru', $nip)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('kode_kriteria', $kode_kriteria)
                ->first();
            $nilaiGuru->id_nilai_kriteria = $id_nilai_kriteria;
            $nilaiGuru->save();
        }

        return redirect()->route('nilai_guru.index',  ['tahun_ajaran' => $tahunAjaran])->with('successmessage', 'Data berhasil disimpan!');
    }
}
