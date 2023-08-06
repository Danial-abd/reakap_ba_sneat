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

    Berikut total pemasangan tahun ini : <br>

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
                        <h4>{{ $carbon }}</h4>
                        @foreach ($totalpsb as $total)
                            @if ($total->month == $bln->month)
                                <h6>Total Pemasangan = {{ $total->count }} </h6>
                            @endif
                        @endforeach
                    </div>
                        <div class="table-respomsive">
                            <table class="table">
                                <thead class=" table-light">
                                    <tr>
                                        <th>
                                            Sektor
                                        </th>
                                        <th>
                                            Jumlah
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($perfpsb as $perf)
                                        @if ($bln->month == $perf->month)
                                            <tr>
                                                <td>
                                                    {{ $perf->sektor }}
                                                </td>
                                                <td>
                                                    {{ $perf->count }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
