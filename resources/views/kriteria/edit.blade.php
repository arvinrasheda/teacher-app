@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Edit Kriteria
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>List Kriteria</li>
            <li class="active">Edit Kriteria</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Kriteria</h3>

                <div class="box-tools pull-right">
                </div>
            </div>
            <form action="{{route('kriteria.update')}}" method="post">
                @csrf
                <div class="box-body">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control" placeholder="Enter ..." name="kode_kriteria" value="{{ $data->kode_kriteria }}">
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" placeholder="Enter ..." name="nama_kriteria" value="{{ $data->nama_kriteria }}">
                    </div>

                    <div class="form-group">
                        <label>Attribut</label>
                        <select class="form-control" name="attribute">
                            <option value="BENEFIT" @if($data->attribute == 'BENEFIT') selected @endif>Benefit</option>
                            <option value="COST" @if($data->attribute == 'COST') selected @endif>Cost</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Bobot</label>
                        <input type="number" class="form-control" placeholder="Enter ..." name="bobot"  value="{{ $data->bobot }}">
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
