@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Edit Guru : <b>{{ $data->nama }}</b>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>List Guru</li>
            <li class="active">Edit Guru</li>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" class="form-control" placeholder="Isi NIP Guru" name="nip" value="{{ $data->nip }}">
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" placeholder="Isi Nama Guru" name="nama" value="{{ $data->nama }}">
                            </div>
                            <div class="form-group">
                                <label>Masa Bakti (dalam Tahun)</label>
                                <input type="number" class="form-control" placeholder="Isi Masa Bakti Guru" name="masa_bakti" value="{{ $data->masa_bakti }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin">
                                    <option value="L" {{ $data->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki - Laki</option>
                                    <option value="P" {{ $data->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Posisi</label>
                                <select class="form-control" name="posisi">
                                    <option value="SUBJECT" {{ $data->posisi === 'SUBJECT' ? 'selected' : '' }}>Subject</option>
                                    <option value="WALI_KELAS" {{ $data->posisi === 'WALI_KELAS' ? 'selected' : '' }}>Wali Kelas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Pendidikan</label>
                                <select class="form-control" name="pendidikan">
                                    <option value="S1" {{ $data->pendidikan === 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ $data->pendidikan === 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ $data->pendidikan === 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>
                        </div>
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
