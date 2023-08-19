@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tambah Nilai Kriteria
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>List Nilai Kriteria</li>
            <li class="active">Tambah Nilai Kriteria</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Nilai Kriteria</h3>

                <div class="box-tools pull-right">
                </div>
            </div>
            <form action="{{route('nilai_kriteria.store')}}" method="post">
                @csrf
                <div class="box-body">

                    <div class="form-group">
                        <label>Kriteria</label>
                        <select class="form-control" name="kode_kriteria">
                            @foreach($kriteria as $item)
                                <option value="{{ $item->kode_kriteria }}">{{ $item->nama_kriteria }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <select class="form-control" name="keterangan">
                            @foreach(['Sangat Baik', 'Baik', 'Cukup Baik', 'Kurang Baik'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Bobot</label>
                        <input type="number" class="form-control" placeholder="Enter ..." name="nilai">
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
