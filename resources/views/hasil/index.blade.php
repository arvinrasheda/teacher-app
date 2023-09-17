@php use App\Services\GuruServices; @endphp
@extends('layouts.app')

@section('css')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Hasil perangkingan
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Hasil perangkingan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Perangkingan Dengan Metode SAW
                    <select onchange="onChangeTahunAjaran(this)" name="tahun_ajaran" style="margin-left: 5px">
                        @foreach($tahunAjaranList as $key => $value)
                            <option value="{{ $key }}" {{ $key == $tahunAjaran ? 'selected' : '' }}> {{$value}}</option>
                        @endforeach
                    </select>
                </h3>


{{--                <div class="box-tools pull-right">--}}
{{--                    <a href="{{ route('hasil.generate') }}">Generate PDF</a>--}}
{{--                </div>--}}
            </div>

            <div class="box-body">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Hasil Analisa</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                @foreach($listKriteria as $item)
                                    <th>{{$item->nama_kriteria}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->nama_guru }}</td>
                                    @foreach($listKriteria as $kriteria)
                                        <td>{{ GuruServices::getItemKeterangan($item->nip_guru, $kriteria->kode_kriteria, $item->tahun_ajaran) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br> <br>
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                @foreach($listKriteria as $item)
                                    <th>{{$item->kode_kriteria}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->nip_guru }}</td>
                                    @foreach($listKriteria as $kriteria)
                                        <td>{{ GuruServices::getItemNilai($item->nip_guru, $kriteria->kode_kriteria, $item->tahun_ajaran) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Normalisasi</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                @foreach($listKriteria as $item)
                                    <th>{{$item->nama_kriteria}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->nama_guru }}</td>
                                    @foreach($listKriteria as $kriteria)
                                        <td>{{ number_format(GuruServices::getNormalisasi($item->nip_guru, $kriteria->kode_kriteria, $item->tahun_ajaran), 2) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Perhitungan Dengan bobot</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @php
                            $rankList = [];
                        @endphp
                        <table id="example3" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                @foreach($listKriteria as $item)
                                    <th>{{$item->nama_kriteria}}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Bobot</td>
                                @foreach($listKriteria as $item)
                                    <th style="color: red">{{ number_format($item->bobot / 100, 2 )}}</th>
                                @endforeach
                                <td></td>
                            </tr>
                            @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->nama_guru }}</td>
                                    @php
                                        $total = 0
                                    @endphp
                                    @foreach($listKriteria as $kriteria)
                                        @php
                                            $subtotal = number_format(GuruServices::getPerangkingan($item->nip_guru, $kriteria->kode_kriteria, number_format(GuruServices::getNormalisasi($item->nip_guru, $kriteria->kode_kriteria, $item->tahun_ajaran), 2)), 2);
                                            $total += $subtotal;
                                        @endphp
                                        <td>{{ $subtotal }}</td>
                                    @endforeach
                                    @php
                                        $rankList[] = [
                                            'nama' => $item->nama_guru,
                                            'total' => floatval($total)
                                        ];
                                    @endphp
                                    <td>{{ $total }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Rank Guru</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @php
                            usort($rankList, function($a, $b) {
                                return $a['total'] <= $b['total'];
                            });
                        @endphp
                        <table id="example4" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Nama</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach($rankList as $item)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['total'] }}</td>
                                </tr>
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <br>
                        Diproses : <b>{{ now()->format('d F Y H:i:s') }}</b>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection
@section('js')
    <script>
        function onChangeTahunAjaran(select) {
            var selectedValue = select.value;
            window.location.href = window.location.pathname + "?tahun_ajaran=" + selectedValue;
        }
    </script>
@endsection

