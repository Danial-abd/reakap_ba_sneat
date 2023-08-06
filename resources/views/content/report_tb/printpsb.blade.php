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

    Berikut 3 Tim dari masing-masing sektor dengan pemasangan terbanyak di bulan {{ $bln }} : <br>

    <br />
    <br />

    <table class="table table-bordered">
        <tr>
            <td colspan="3">Sektor KYG</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Tim</th>
            <th>Total Pengerjaan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($teamkyg as $team)
            @foreach ($hitungkyg as $hitung)
                @if ($team->id == $hitung->id)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $hitung->list_tim }}</td>
                        <td>{{ $hitung->tikettims_count }}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </table>

    <br />

    <table class="table table-bordered">
        <tr>
            <td colspan="3">Sektor BJM</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Tim</th>
            <th>Total Pengerjaan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($teambjm as $team)
            @foreach ($hitungbjm as $hitung)
                @if ($team->id == $hitung->id)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $hitung->list_tim }}</td>
                        <td>{{ $hitung->tikettims_count }}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach

    </table>

    <br />

    <table class="table table-bordered">
        <tr>
            <td colspan="3">Sektor ULI</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Tim</th>
            <th>Total Pengerjaan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @forelse ($teamuli as $team)
            @foreach ($hitunguli as $hitung)
                @if ($team->id == $hitung->id)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $hihitung->list_tim }}</td>
                        <td>{{ $hitung->tikettims_count }}</td>
                    </tr>
                @endif
            @endforeach
        @empty
            <tr>
                <td colspan="3" align='middle'>Team Kosong</td>
            </tr>
        @endforelse

    </table>

    <br><br>

    <p align="left">
        Banjarmasin, <?php $tgl = date('d-m-Y');
        echo $tgl; ?><br><br>ARIF ACHMADI<br>
        -----------------------<br>
        SITE MANAGER
    </p>

</body>

</html>
