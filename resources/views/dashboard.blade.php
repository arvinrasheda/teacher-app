@php use App\Services\GuruServices; @endphp
@extends('layouts.app')

@section('css')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

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
                    <a href="{{ route('guru.index') }}" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-9 col-xs-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Rank Guru Tahun Ajaran {{ date('Y') - 1 }} / {{ date('Y') }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @php
                            $rankList = [];
                        @endphp

                        @foreach($list as $item)
                            @php
                                $total = 0;
                            @endphp
                            @foreach($listKriteria as $kriteria)
                                @php
                                    $subtotal = number_format(GuruServices::getPerangkingan($item->nip_guru, $kriteria->kode_kriteria, number_format(GuruServices::getNormalisasi($item->nip_guru, $kriteria->kode_kriteria, date('Y')), 2)), 2);
                                    $total += $subtotal;
                                @endphp
                            @endforeach
                            @php
                                $rankList[] = [
                                    'nama' => $item->nama_guru,
                                    'total' => floatval($total)
                                ];
                            @endphp
                        @endforeach
                        @php
                            usort($rankList, function($a, $b) {
                                return $a['total'] <= $b['total'];
                            });
                        @endphp
                        <table id="example4" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Nama</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach($rankList as $item)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item['nama'] }}</td>
                                    <td>{{ $item['total'] }}</td>
                                </tr>
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="posisi_guru"></div>
            </div>
            <div class="col-md-6">
                <div id="masa_bakti"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="jenis_kelamin"></div>
            </div>
            <div class="col-md-6">
                <div id="pendidikan"></div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        Highcharts.chart('posisi_guru', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: 'Posisi Guru',
                align: 'left'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '24px',
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Persentase',
                data: [
                    ['Subject', {{ $posisiSubject }}],
                    ['Wali Kelas', {{ $posisiWaliKelas }}]
                ]
            }]
        });
        Highcharts.chart('masa_bakti', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Masa Bakti Guru',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Persentase',
                colorByPoint: true,
                data: [{
                    name: '> 10 Tahun',
                    y: {{ $dataMasaBaktiLebihDari10Tahun }},
                    sliced: true,
                    selected: true
                },  {
                    name: '< 10 Tahun',
                    y: {{ $dataMasaBaktiKurangDari10Tahun }}
                },  {
                    name: '< 5 Tahun',
                    y: {{ $dataMasaBaktiKurangDari5Tahun }}
                }]
            }]
        });
        Highcharts.chart('jenis_kelamin', {
            chart: {
                type: 'pie',
            },
            title: {
                text: 'Jenis Kelamin Guru',
                align: 'left'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.percentage:.1f}%',
                    }
                }
            },
            series: [{
                name: 'Jenis Kelamin',
                data: [
                    {
                        name: 'Laki-Laki',
                        y: {{ $maleCount }},
                        sliced: true, // Jika ingin potongan (slice) aktif
                        selected: true // Jika ingin opsi ini terpilih secara default
                    },
                    {
                        name: 'Perempuan',
                        y: {{ $femaleCount }}
                    }
                ]
            }]
        });
        Highcharts.chart('pendidikan', {
            chart: {
                type: 'column',
            },
            title: {
                text: 'Grafik Tingkat Pendidikan',
                align: 'left'
            },
            xAxis: {
                categories: ['S1', 'S2', 'S3'],
            },
            yAxis: {
                title: {
                    text: 'Jumlah Guru',
                },
            },
            series: [{
                name: 'Jumlah Guru',
                data: [
                    {{ $s1Count }},
                    {{ $s2Count }},
                    {{ $s3Count }},
                ],
                colorByPoint: true, // Aktifkan opsi ini untuk memberikan warna berbeda untuk setiap kategori
                colors: [
                    'blue', // Warna untuk S1
                    'green', // Warna untuk S2
                    'orange', // Warna untuk S3
                ],
            }]
        });
    </script>
@endsection
