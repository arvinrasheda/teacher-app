<?php

namespace App\Http\Controllers;

use App\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilController extends Controller
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
        $list = DB::select('
            SELECT
                guru.id,
                nilai_guru.nip_guru,
                guru.nama AS nama_guru,
                nilai_guru.tahun_ajaran
            FROM
                "nilai_guru"
                LEFT JOIN guru ON guru.nip = nilai_guru.nip_guru
            WHERE nilai_guru.tahun_ajaran = :tahunAjaran OR nilai_guru.tahun_ajaran IS NULL AND nilai_guru.id_nilai_kriteria IS NOT NULL
            GROUP BY
                guru.nama,
                nilai_guru.nip_guru,
                nilai_guru.tahun_ajaran,
                guru.id
        ', ['tahunAjaran' => $tahunAjaran]);

        return view('hasil.index', compact('listKriteria', 'list', 'tahunAjaranList', 'tahunAjaran'));
    }
    public function generatePdf(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran') ?: date('Y');
        // Buat instance PDF menggunakan TCPDF
        $pdf = new \TCPDF();

        // Set dokumen PDF
        $pdf->SetTitle('Hasil Perangkingan');
        $pdf->SetHeaderData('', 0, 'Hasil Perangkingan Tahun Ajaran ' . ($tahunAjaran - 1) . '/' . $tahunAjaran , '');
        // Tambahkan halaman baru
        $pdf->AddPage();

        // Konten halaman PDF
        $listKriteria = Kriteria::select('*')->orderBy('kode_kriteria')->get();
        $tahunAjaranList = [
            '2022' => 'Tahun Ajaran 2021/2022',
            '2023' => 'Tahun Ajaran 2022/2023',
            '2024' => 'Tahun Ajaran 2023/2024'
        ];
        $list = DB::select('
            SELECT
                guru.id,
                nilai_guru.nip_guru,
                guru.nama AS nama_guru,
                nilai_guru.tahun_ajaran
            FROM
                "nilai_guru"
                LEFT JOIN guru ON guru.nip = nilai_guru.nip_guru
            WHERE nilai_guru.tahun_ajaran = :tahunAjaran OR nilai_guru.tahun_ajaran IS NULL AND nilai_guru.id_nilai_kriteria IS NOT NULL
            GROUP BY
                guru.nama,
                nilai_guru.nip_guru,
                nilai_guru.tahun_ajaran,
                guru.id
        ', ['tahunAjaran' => $tahunAjaran]);
        $html = view('hasil.pdf', compact('listKriteria', 'list', 'tahunAjaranList', 'tahunAjaran'))->render();
        $pdf->writeHTML($html);

        // Keluarkan PDF sebagai respons
        $pdf->Output('hasil_perangkingan.pdf', 'D');
    }
}
