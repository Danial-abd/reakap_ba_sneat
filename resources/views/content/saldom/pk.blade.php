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
    <br/>   

    Berikut Tim yang belum melakukan pengembalian bulan {{ $bln }} :

    <br/>
    <br/>
    @foreach ($team as $t)

        <table class="table table-bordered">
            <tr>
                <td colspan="4">{{ $t->list_tim }}</td>
            </tr>
            <tr>
                <th>No</th>
                <th>Nama Material</th>
                <th>Belum Kembali</th>
                <th>Cek</th>
            </tr>
            @php
                $no = 1;
            @endphp
            
                @foreach ($saldopsb as $saldo)
                    @if ($t->id == $saldo->id_tim)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                            {{ $saldo->material->nama_material }}
                        </td>
                        <td>{{ $saldo->total_jumlah }} {{ $saldo->total_jumlah > 50 ? 'M' : 'Pcs' }} </td>
                        <td align="middle"> </td>
                    </tr>
                    @endif
                @endforeach
            
        </table>
    
    @endforeach

    <br><br>

    <p align="left">
        Banjarmasin, <?php $tgl = date('d-m-Y');
        echo $tgl; ?><br><br>ARIF ACHMADI<br>
        -----------------------<br>
        SITE MANAGER
    </p>

</body>

</html>
