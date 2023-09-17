@php use App\Services\GuruServices; @endphp

<h3>Hasil Analisa</h3>

<br><br>

<table border="1">
    <thead>
    <tr>
        <th>#</th>
        @foreach ($listKriteria as $item)
            <th style="padding: 10px;">{{ $item->nama_kriteria }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($list as $item)
        <tr>
            <td>{{ $item->nama_guru }}</td>
            @foreach ($listKriteria as $kriteria)
                <td style="padding: 10px;">{{ GuruServices::getItemKeterangan($item->nip_guru, $kriteria->kode_kriteria, $item->tahun_ajaran) }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

<br><br>

<h3>Normalisasi</h3>

<br><br>

<table border="1">
    <thead>
    <tr>
        <th>#</th>
        @foreach ($listKriteria as $item)
            <th style="padding: 10px;">{{ $item->nama_kriteria }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($list as $item)
        <tr>
            <td>{{ $item->nama_guru }}</td>
            @foreach ($listKriteria as $kriteria)
                <td style="padding: 10px;">{{ number_format(GuruServices::getNormalisasi($item->nip_guru, $kriteria->kode_kriteria, $item->tahun_ajaran), 2) }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

<br><br>

<h3>Perhitungan Dengan bobot</h3>

<br><br>

<table border="1">
    <thead>
    <tr>
        <th>#</th>
        @foreach ($listKriteria as $item)
            <th style="padding: 10px;">{{ $item->nama_kriteria }}</th>
        @endforeach
        <th style="padding: 10px;">Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Bobot</td>
        @foreach ($listKriteria as $item)
            <th style="padding: 10px; color: red">{{ number_format($item->bobot / 100, 2) }}</th>
        @endforeach
        <td style="padding: 10px;"></td>
    </tr>
    @foreach ($list as $item)
        <tr>
            <td>{{ $item->nama_guru }}</td>
            @php
                $total = 0
            @endphp
            @foreach ($listKriteria as $kriteria)
                @php
                    $subtotal = number_format(GuruServices::getPerangkingan($item->nip_guru, $kriteria->kode_kriteria, number_format(GuruServices::getNormalisasi($item->nip_guru, $kriteria->kode_kriteria, $item->tahun_ajaran), 2)), 2);
                    $total += $subtotal;
                @endphp
                <td style="padding: 10px;">{{ $subtotal }}</td>
            @endforeach
            @php
                $rankList[] = [
                    'nama' => $item->nama_guru,
                    'total' => floatval($total)
                ];
            @endphp
            <td style="padding: 10px;">{{ $total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br><br>

<h3>Rank Guru</h3>

<br><br>

<table border="1">
    <thead>
    <tr>
        <th>#</th>
        <th style="padding: 10px;">Nama</th>
        <th style="padding: 10px;">Total</th>
    </tr>
    </thead>
    <tbody>
    @php
        usort($rankList, function ($a, $b) {
            return $a['total'] <= $b['total'];
        });
    @endphp
    @php
        $no = 1;
    @endphp
    @foreach ($rankList as $item)
        <tr>
            <td>{{ $no }}</td>
            <td style="padding: 10px;">{{ $item['nama'] }}</td>
            <td style="padding: 10px;">{{ $item['total'] }}</td>
        </tr>
        @php
            $no++;
        @endphp
    @endforeach
    </tbody>
</table>

<br><br><br>
Diproses : <b>{{ now()->format('d F Y H:i:s') }}</b>
