<!DOCTYPE html>
<html>

<head>
    <title>{{ $pdfname }}</title>
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
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <hr>
    <center>
        <h5>Data Anggota Tim</h4>
    </center>
    <br />
    <br />
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>NO</th>
                <th>Tim</th>
                <th>Nama Anggota</th>
                <th>Pekerjaan</th>
                <th>Ket</th>
            </tr>
            @php
                $no = 1;
            @endphp
            @foreach ($teamdetail as $td)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $td->teamlist->list_tim }}</td>
                    <td>{{ $td->karyawan->nama }}</td>
                    <td>{{ $td->jobdesk->jobdesk }} {{ $td->jobdesk->detail_kerja }}</td>
                    <td>{{ $td->ket }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
