@php use App\Services\GuruServices; @endphp
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{url('public/plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Penilaian Guru
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Penilaian Guru</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Penilaian Guru
                    <select onchange="onChangeTahunAjaran(this)" name="tahun_ajaran" style="margin-left: 5px">
                        @foreach($tahunAjaranList as $key => $value)
                            <option value="{{ $key }}" {{ $key == $tahunAjaran ? 'selected' : '' }}> {{$value}}</option>
                        @endforeach
                    </select>
                </h3>

                <div class="box-tools pull-right">
                    <a id="btnTambah" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah</a>
                </div>

            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th>Tahun Ajaran</th>
                        @foreach($listKriteria as $item)
                            <th>{{$item->nama_kriteria}}</th>
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach($list as $item)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $item->nip_guru }}</td>
                            <td>{{ $item->nama_guru }}</td>
                            <td>{{ $item->tahun_ajaran - 1 }}/{{ $item->tahun_ajaran}}</td>
                            @foreach($listKriteria as $kriteria)
                                <td>{{ GuruServices::getItemKeterangan($item->nip_guru, $kriteria->kode_kriteria, $item->tahun_ajaran) }}</td>
                            @endforeach
                            <td>
                                <a href="{{ route('nilai_guru.edit', ['nip' => $item->nip_guru]) }}?tahun_ajaran={{$item->tahun_ajaran}}" class="btn btn-outline-warning"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        @php
                            $no++
                        @endphp
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

        <div class="modal fade" id="modalTambah">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Tambah Penilaian Guru</h4>
                    </div>
                    <form action="{{ route('nilai_guru.addFromTahunAjaran') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <select class="form-control" name="tahun_ajaran" required>
                                    @foreach($tahunAjaranList as $key => $value)
                                        <option value="{{ $key }}" {{ $key == $tahunAjaran ? 'selected' : '' }}> {{$value}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Guru</label>
                                <select class="form-control" name="nip" required>
                                    @foreach($guruList as $key => $value)
                                        <option value="{{ $value->nip }}"> {{$value->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('js')
    <script src="{{url('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('public/plugins/datatables/dataTables.bootstrap.js')}}"></script>
    <script>
        $(function () {
            $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            });
            $("#btnTambah").click(function () {
                $("#modalTambah").modal('show');
            });
        })
        function onChangeTahunAjaran(select) {
            var selectedValue = select.value;
            window.location.href = window.location.pathname + "?tahun_ajaran=" + selectedValue;
        }
    </script>
@endsection
