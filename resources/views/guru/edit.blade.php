@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tambah Guru
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>List Guru</li>
            <li class="active">Tambah Guru</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Guru</h3>

                <div class="box-tools pull-right">
                </div>
            </div>
            <form action="{{route('guru.update')}}" method="post">
                @csrf
                <div class="box-body">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" class="form-control" placeholder="Enter ..." name="nip" value="{{ $data->nip }}">
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" placeholder="Enter ..." name="nama" value="{{ $data->nama }}">
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" placeholder="Enter ..." name="keterangan" value="{{ $data->keterangan }}">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>

            </form>
            <!-- /.box-footer-->
        </div>
    </section>
@endsection
