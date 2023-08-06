<!DOCTYPE html>
<html lang="en">

<head>
    <title>PT. UPAYA TEHNIK</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <table style="width: 100%" class="align-middle">
        <tr>
            <td style="width: 80%">
                <h4>PT. UPAYA TEHNIK</h3><br>
                    <h6>Jl. Dharma Bakti V RT 14 Nomor 19 <BR>
                        Banjarmasin Timur Kalimantan Selatan
                    </h6>
            </td>
            <td>
            </td>
            <td>
                <img src="{{ public_path('assets/img/favicon/logo.png') }}" width="200" height="140">
            </td>
        </tr>
    </table>

</head>

<body>

    <hr>
    <center>
        <h4>{{ $pdfname }}</h4>
    </center>
    <?php $tgl = date('d-m-Y');
    echo $tgl; ?>
    <br />

    Berikut data penyebab gangguan dimasing-masing sektor` : <br>

    <br />
    <br />


    @forelse ($blan as $bln)
        @php
            if ($bln->month == 1) {
                $carbon = 'Januari';
            } elseif ($bln->month == 2) {
                $carbon = 'Februari';
            } elseif ($bln->month == 3) {
                $carbon = 'Maret';
            } elseif ($bln->month == 4) {
                $carbon = 'April';
            } elseif ($bln->month == 5) {
                $carbon = 'Mei';
            } elseif ($bln->month == 6) {
                $carbon = 'Juni';
            } elseif ($bln->month == 7) {
                $carbon = 'Juli';
            } elseif ($bln->month == 8) {
                $carbon = 'Agustus';
            } elseif ($bln->month == 9) {
                $carbon = 'September';
            } elseif ($bln->month == 10) {
                $carbon = 'Oktober';
            } elseif ($bln->month == 11) {
                $carbon = 'November';
            } elseif ($bln->month == 12) {
                $carbon = 'Desember';
            }
        @endphp
        <div class="card mb-4">
            <div class="card-header">
                <h5>{{ $carbon }}</h5 >
            </div>
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="3">
                            <p class="fs-5">KYG</p>
                            @foreach ($totalkyg as $total)
                                @if ($total->month == $bln->month)
                                    <p class="fs-7 mb-0">Total Tiket : {{ $total->count }}</p>
                                @endif
                            @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Pengebab Gangguan
                        </th>
                        <th>
                            Jumlah
                        </th>
                        <th>
                            Persen
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($perfpsb as $perf)
                        @if ($perf->month == $bln->month)
                            @if ($perf->sektor == 'KYG')
                                <tr>
                                    <td>
                                        {{ $perf->penyebab }}
                                    </td>
                                    <td>
                                        {{ $perf->count }}
                                    </td>
                                    <td>
                                        @foreach ($totalkyg as $total)
                                            @if ($total->month == $bln->month)
                                                {{ number_format(($perf->count / $total->count) * 100)}}%
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td align="center" colspan="3">
                                        Data Kosong
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @empty
                        <tr>
                            <td align="center" colspan="3">
                                Data Kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
<br> 
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="3">
                            <p class="fs-5">BJM</p>
                            @foreach ($totalbjm as $total)
                                @if ($total->month == $bln->month)
                                    <p class="fs-7 mb-0">Total Tiket : {{ $total->count }}</p>
                                @endif
                            @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Pengebab Gangguan
                        </th>
                        <th>
                            Jumlah
                        </th>
                        <th>
                            Persen
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($perfpsb as $perf)
                        @if ($perf->month == $bln->month)
                            @if ($perf->sektor == 'BJM')
                                <tr>
                                    <td>
                                        {{ $perf->penyebab }}
                                    </td>
                                    <td>
                                        {{ $perf->count }}
                                    </td>
                                    <td>
                                        @foreach ($totalbjm as $total)
                                            @if ($total->month == $bln->month)
                                                {{ number_format(($perf->count / $total->count) * 100)}}%
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td align="center" colspan="3">
                                        Data Kosong
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @empty
                        <tr>
                            <td align="center" colspan="3">
                                Data Kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
<br>
            <table class="table table-bordered ">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="3">
                            <p class="fs-5">ULI</p>
                            @foreach ($totaluli as $total)
                                @if ($total->month == $bln->month)
                                    <p class="fs-7 mb-0">Total Tiket : {{ $total->count }}</p>
                                @endif
                            @endforeach
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Pengebab Gangguan
                        </th>
                        <th>
                            Jumlah
                        </th>
                        <th>
                            Persen
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($perfpsb as $perf)
                        @if ($perf->month == $bln->month)
                            @if ($perf->sektor == 'ULI')
                                <tr>
                                    <td>
                                        {{ $perf->penyebab }}
                                    </td>
                                    <td>
                                        {{ $perf->count }}
                                    </td>
                                    <td>
                                        @foreach ($totaluli as $total)
                                            @if ($total->month == $bln->month)
                                                {{ number_format(($perf->count / $total->count) * 100)}}%
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td align="center" colspan="3">
                                        Data Kosong
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @empty
                        <tr>
                            <td align="center" colspan="3">
                                Data Kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @empty
        <div class="card mb-4">
            <div class="card-body">
                <p>Data Kosong</p>
            </div>
        </div>
    @endforelse


    <br><br>

    <p align="left">
        Banjarmasin, <?php $tgl = date('d-m-Y');
        echo $tgl; ?><br><br>ARIF ACHMADI<br>
        -----------------------<br>
        SITE MANAGER
    </p>

</body>

</html>
