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
        <h2>Data Tiket Maintenance</h2>
    </center>
    <br>
    <div class="table-responsive">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>No Tiket</th>
                    <th>Jenis Tiket</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Tiket Open</th>
                    <th>Ket</th>
                </tr>
                @php
                    $no = 1;
                @endphp
                @foreach ($tiketlist as $tl)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $tl->no_tiket }}</td>
                        <td>{{ $tl->jenistiket->nama_tiket }}</td>
                        <td>{{ $tl->nama_pic }}</td>
                        <td>{{ $tl->alamat }}</td>
                        <td>{{ $tl->no_pic }}</td>
                        <td>{{ $tl->created_at }}</td>
                        <td>{{ $tl->ket }}</td>
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
