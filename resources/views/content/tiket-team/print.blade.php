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
        <h4>{{ $pdfname }}</h4>
    </center>

    <p>Total Pengerjaan Tiket Dalam Sebulan</p><br>
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
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Tim</th>
                    <th>Anggota</th>
                    <th>No Tiket</th>
                    <th>Nama PIC</th>
                    <th>No PIC</th>
                    <th>alamat</th>
                    <th>Pekerjaan</th>
                    <th>Ket</th>
                    <th>Tanggal Upload</th>
                </tr>
            </thead>
                @php
                    $no = 1;
                @endphp
            <tbody>
                @foreach ($tiktim as $t)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $t->teamlist->list_tim }}</td>
                        <td>{{ $t->teamdetail->karyawan->nama }}</td>
                        <td>{{ $t->tiketlist->no_tiket }}</td>
                        <td>{{ $t->tiketlist->nama_pic }}</td>
                        <td>{{ $t->tiketlist->no_pic }}</td>
                        <td>{{ $t->tiketlist->alamat }}</td>
                        <td>{{ $t->tiketlist->jenistiket->nama_tiket }}</td>
                        <td>{{ $t->tiketlist->ket }}</td>
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
