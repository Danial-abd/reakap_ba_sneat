@extends('layouts/contentNavbarLayout')

@section('title', 'Data Total Material')

@section('content')

    {{-- <div class="container"> --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            @php
                if ($bln == 1) {
                    $buln = 'Januari';
                } elseif ($bln == 2) {
                    $buln = 'Februari';
                } elseif ($bln == 3) {
                    $buln = 'Maret';
                } elseif ($bln == 4) {
                    $buln = 'April';
                } elseif ($bln == 5) {
                    $buln = 'Mei';
                } elseif ($bln == 6) {
                    $buln = 'Juni';
                } elseif ($bln == 7) {
                    $buln = 'Juli';
                } elseif ($bln == 8) {
                    $buln = 'Agustus';
                } elseif ($bln == 9) {
                    $buln = 'September';
                } elseif ($bln == 10) {
                    $buln = 'Oktober';
                } elseif ($bln == 11) {
                    $buln = 'November';
                } elseif ($bln == 12) {
                    $buln = 'Desember';
                }
            @endphp
            <tr>
                <td class="col-md-8">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        Tim PSB dengan pemasangan terbanyak bulan {{ $buln }}
                    </h4>
                </td>

                <form action="{{ route('printps-b') }}" method="get" target="_blank" class="form-item" enctype="multipart/form-data">
                    <td class="col-md-2">
                        @php
                            $bln = date('m');
                        @endphp
                        <select name="bulan" class="form-control mb-4">
                            <option value="" disabled selected>--Bulan--</option>
                            <option value="1" {{ $bln == 1 ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ $bln == 02 ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ $bln == 03 ? 'selected' : '' }}>Maret</option>
                            <option value="4" {{ $bln == 04 ? 'selected' : '' }}>April</option>
                            <option value="5" {{ $bln == 05 ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ $bln == 06 ? 'selected' : '' }}>Juni</option>
                            <option value="7" {{ $bln == 07 ? 'selected' : '' }}>Juli</option>
                            <option value="8" {{ $bln == 8 ? 'selected' : '' }}>Agustus</option>
                            <option value="9" {{ $bln == 9 ? 'selected' : '' }}>September</option>
                            <option value="10" {{ $bln == 10 ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ $bln == 11 ? 'selected' : '' }}>November</option>
                            <option value="12" {{ $bln == 12 ? 'selected' : '' }}>Desember</option>
                        </select>
                    </td>
                    <td class="col-md-2 col-2">
                        <input type="text" readonly class="form-control mb-4 ms-1" value="<?php $tahun = date('Y');
                        echo $tahun; ?>">
                        <input type="hidden" name="tahun" class="form-control mb-4" value="<?php $tahun = date('Y');
                        echo $tahun; ?>">
                    </td>
                    <td class="col-auto">
                        <button type="submit" target="_blank" class="btn btn-info mb-4 float-end ms-2">print</button>
                    </td>
                </form>
            </tr>
        </table>
    </div>
    {{-- /form print --}}

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <form action="" method="GET" class="form-item">
                        <div class="row justify-content-end">
                            <div class="col-6 col-sm-3 ms-0 mt-2 d-grid">
                                @php
                                    $bln = date('m');
                                @endphp
                                <select name="bulan" class="form-control">
                                    <option value="" disabled selected>--Bulan--</option>
                                    <option value="1" {{ $bln == 1 ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ $bln == 2 ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ $bln == 3 ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ $bln == 4 ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ $bln == 5 ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ $bln == 6 ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ $bln == 7 ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ $bln == 8 ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ $bln == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $bln == 10 ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $bln == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $bln == 12 ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                            <div class="col-auto mt-2">
                                <button type="submit" class="btn btn-info" name="cari">Cari</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <p class="fs-5 fw-bold">KYG</p>
            </div>
            <div class="card-body">
                <div class="table-responsive text nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Tim</td>
                                <td>Total Pengerjaan</td>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($teamkyg as $team)
                            @foreach ($hitungkyg as $hitung)
                                @if ($team->id == $hitung->id)
                                    <tbody>
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $hitung->list_tim }}</td>
                                            <td>{{ $hitung->tikettims_count }}</td>
                                        </tr>
                                    </tbody>
                                @endif
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <p class="fs-5 fw-bold">BJM</p>
            </div>
            <div class="card-body">
                <div class="table-responsive text nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Tim</td>
                                <td>Total Pengerjaan</td>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($teambjm as $team)
                            @foreach ($hitungbjm as $hitung)
                                @if ($team->id == $hitung->id)
                                    <tbody>
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $hitung->list_tim }}</td>
                                            <td>{{ $hitung->tikettims_count }}</td>
                                        </tr>
                                    </tbody>
                                @endif
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <p class="fs-5 fw-bold">ULI</p>
            </div>
            <div class="card-body">
                <div class="table-responsive text nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Tim</td>
                                <td>Total Pengerjaan</td>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($teamuli as $team)
                            @foreach ($hitunguli as $hitung)
                                @if ($team->id == $hitung->id)
                                    <tbody>
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $hihitung->list_tim }}</td>
                                            <td>{{ $hitung->tikettims_count }}</td>
                                        </tr>
                                    </tbody>
                                @endif
                              
                            
                            @endforeach
                            @empty
                            <tbody>
                                <tr>
                                    <td colspan="3" align='middle'>Team Kosong</td>
                                </tr>
                            </tbody>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
