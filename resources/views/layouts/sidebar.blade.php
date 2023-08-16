<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ (request()->is('/')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

            <li class="treeview {{ (request()->is('/master')) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Master</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ (request()->is('/kriteria')) ? 'active' : '' }}"><a href="{{ route('kriteria.index') }}"><i class="fa fa-circle-o"></i> Kriteria</a></li>
                    <li class="{{ (request()->is('/nilai-kriteria')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-circle-o"></i> Nilai Kriteria</a></li>
                </ul>
            </li>
            <li class="{{ (request()->is('/kriteria')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-folder"></i> <span>Data Guru</span></a></li>
            <li class="{{ (request()->is('/kriteria')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-files-o"></i> <span>Input Penilaian Guru</span></a></li>
            <li class="{{ (request()->is('/kriteria')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-pie-chart"></i> <span>Hasil Metode SAW</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
