@extends('layouts.app')


@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>it all starts here</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#" class="active"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box" style="background-color: #613813">
                    <div class="inner">
                        <h3 style="color: white">{{ $countGuru }}</h3>
                        <p style="color: white">Data Guru</p>
                    </div>
                    <div class="icon">
                        <i style="color: white" class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('guru.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

    </section>
@endsection
