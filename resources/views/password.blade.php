@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Ubah Password: <b>{{ ucfirst(str_replace('_', ' ', $user->username)) }}</b>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Ubah Password</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Password</h3>

                <div class="box-tools pull-right">
                </div>
            </div>
            <form action="{{ route('password.store') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
                <div class="box-body">
                    <div class="form-group">
                        <label>Password lama</label>
                        <input type="password" class="form-control" name="old_password">
                    </div>
                    <div class="form-group">
                        <label>Password baru</label>
                        <input type="password" class="form-control" name="new_password">
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
