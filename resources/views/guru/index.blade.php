@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{url('public/plugins/datatables/dataTables.bootstrap.css')}}">
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Data Guru
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List Guru</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Guru</h3>

                <div class="box-tools pull-right">
                    <a href="{{ route('guru.create') }}" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah</a>
                </div>
            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Guru</th>
                        <th>Nama Guru</th>
                        <th>Keterangan</th>
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
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <a class="btn btn-outline-warning"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-outline-warning"><i class="fa fa-trash"></i></a>
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
