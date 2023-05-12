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
    <br>
    <center>
        <h2>Data Karyawan</h2>
    </center>
    <br>
    <div class="table-responsive">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>NO</th>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>TTL</th>
                    <th>Jenis Kelamin</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($karyawan as $kyw)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $kyw->nik }}</td>
                        <td>{{ $kyw->nama }}</td>
                        <td>{{ $kyw->ttl }}</td>
                        <td>{{ $kyw->jns_klmin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $kyw->telepon }}</td>
                        <td>{{ $kyw->alamat }}</td>
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
