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

    Total material bulan {{ $bln }} : <br>
    <small>(belum termasuk material yang dikembalikan, khusus untuk pasang baru harus melakukan pengembalian material)</small>

    <br />
    <br />

    <table class="table table-bordered">
        <tr>
            <td colspan="5">Gangguan</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Material</th>
            <th>Total</th>
            <th>Terpakai</th>
            <th>Sisa</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @forelse ($saldoggn as $ggn)
            <tr>
                <td>{{ $no++ }}</td>
                <td>
                    {{ $ggn->material->nama_material }}
                </td>
                <td>{{ $ggn->jumlah }} {{ $ggn->jumlah > 50 ? 'M' : 'Pcs' }} </td>
                <td> {{ $ggn->guna }} {{ $ggn->guna > 50 ? 'M' : 'Pcs' }}</td>
                <td>{{ $ggn->total_jumlah }} {{ $ggn->total_jumlah > 50 ? 'M' : 'Pcs' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" align="middle"> Data Kosong </td>
            </tr>
        @endforelse
        <tr>
            <td colspan="5">Total Tiket yang dikerjakan = {{ $tiketggn }}</td>
        </tr>

    </table>

    <br />

    <table class="table table-bordered">
        <tr>
            <td colspan="5">Pasang Baru</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Material</th>
            <th>Total</th>
            <th>Terpakai</th>
            <th>Sisa</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @forelse ($saldopsb as $psb)
            <tr>
                <td>{{ $no++ }}</td>
                <td>
                    {{ $psb->material->nama_material }}
                </td>
                <td>{{ $psb->jumlah }} {{ $psb->jumlah > 50 ? 'M' : 'Pcs' }} </td>
                <td> {{ $psb->guna }} {{ $psb->guna > 50 ? 'M' : 'Pcs' }}</td>
                <td>{{ $psb->total_jumlah }} {{ $psb->total_jumlah > 50 ? 'M' : 'Pcs' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" align="middle"> Data Kosong </td>
            </tr>
        @endforelse
        <tr>
            <td colspan="5">Total Tiket yang dikerjakan = {{ $tiketpsb }}</td>
        </tr>

    </table>

    <br />

    <table class="table table-bordered">
        <tr>
            <td colspan="5">Maintenance</td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Material</th>
            <th>Total</th>
            <th>Terpakai</th>
            <th>Sisa</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @forelse ($saldomtn as $mtn)
            <tr>
                <td>{{ $no++ }}</td>
                <td>
                    {{ $mtn->material->nama_material }}
                </td>
                <td>{{ $mtn->jumlah }} {{ $mtn->jumlah > 50 ? 'M' : 'Pcs' }} </td>
                <td> {{ $mtn->guna }} {{ $mtn->guna > 50 ? 'M' : 'Pcs' }}</td>
                <td>{{ $mtn->total_jumlah }} {{ $mtn->total_jumlah > 50 ? 'M' : 'Pcs' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" align="middle"> Data Kosong </td>
            </tr>
        @endforelse
        <tr>
            <td colspan="5">Total Tiket yang dikerjakan = {{ $tiketmtn }}</td>
        </tr>

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
