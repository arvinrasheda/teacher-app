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
                <h3 class="box-title">Penilaian Guru</h3>
            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
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
                            @foreach($listKriteria as $kriteria)
                                <td>{{ GuruServices::getItemKeterangan($item->nip_guru, $kriteria->kode_kriteria) }}</td>
                            @endforeach
                            <td>
                                <a href="{{ route('nilai_guru.edit', ['nip' => $item->nip_guru]) }}" class="btn btn-outline-warning"><i class="fa fa-pencil"></i></a>
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
            })
        })
    </script>
@endsection
