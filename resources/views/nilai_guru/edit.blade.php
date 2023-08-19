@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Input Penilaian: <b>{{ $guru->nama }}</b>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>List Kriteria</li>
            <li class="active">Tambah Kriteria</li>
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
            <form action="{{route('nilai_guru.store', ['nip'=>$nip])}}" method="post">
                @csrf
                <div class="box-body">
                    @foreach($listKriteria as $kriteria)
                        <div class="form-group">
                            <label>{{ $kriteria['nama_kriteria']  }}</label>
                            <select class="form-control" name="{{ $kriteria['kode_kriteria']  }}">
                                @foreach($kriteria['items'] as $item)
                                    <option value="{{ $item['id'] }}" @if($item['selected']) selected @endif>{{ $item['keterangan'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
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
