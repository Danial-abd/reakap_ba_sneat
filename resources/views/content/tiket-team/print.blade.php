<!DOCTYPE html>
<html lang="en">

<head>
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

    <title>PT. UPAYA TEHNIK</title>

</head>

<body>
    <hr>
    <center>
        <h4>{{ $pdfname }}</h4>
    </center>


    Berikut Total Pengerjaan Tiket Dalam Sebulan </br>
    Pada masing-masing tim

    <table style="width: 30%">
        <tr style="width: 25%">
            <th>Nama Tim</th>
            <th></th>
            <th>Total</th>
        </tr>
        @foreach ($hitung as $hitung)
            @if ($hitung->tikettims_count > 0)
                <tr>
                    <td>
                        {{ $hitung->list_tim }}</p>
                    </td>
                    <td>
                        :
                    </td>
                    <td style="text-align: center">
                        {{ $hitung->tikettims_count ?? '' }}
                    </td>
                </tr>
            @endif
        @endforeach
    </table>

    <br>


    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Nama Tim</th>
                <th>Sektor</th>
                <th>No Tiket</th>
                <th>No Internet</th>
                <th>Nama PIC</th>
                <th>No PIC</th>
                <th>alamat</th>
                <th>Ket</th>
                <th>Tanggal Upload</th>
            </tr>
            @php
                $no = 1;
            @endphp
            <tbody>
                @foreach ($tiktim as $t)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $t->teamlist->list_tim }}</td>
                        <td>
                            @foreach ($t->teamdetail->teamlist->sektor as $tl)
                                {{ $tl->sektor }}
                            @endforeach
                        </td>
                        <td>{{ $t->no_tiket }}</td>
                        <td>{{ $t->no_inet }}</td>
                        <td>{{ $t->nama_pic }}</td>
                        <td>{{ $t->no_pic }}</td>
                        <td>{{ $t->alamat }}</td>
                        <td>{{ $t->ket }}</td>
                        <td>{{ $t->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <br><br>

    <p align="left">
        Banjarmasin, <?php $tgl = date('d-m-Y');
        echo $tgl; ?><br><br>ARIF ACHMADI<br>
        -----------------------<br>
        SITE MANAGER
    </p>

</body>

</html>
