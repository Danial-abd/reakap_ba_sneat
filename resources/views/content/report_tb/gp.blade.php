@extends('layouts/contentNavbarLayout')

@section('title', 'Data Penyebab Gangguan')

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
                        Penyebab Gangguan
                    </h4>
                </td>

                <form action="{{ route('print-gp') }}" method="get" target="_blank" class="form-item" enctype="multipart/form-data">
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
                        <input type="hidden" name="year" class="form-control mb-4" value="<?php $tahun = date('Y');
                        echo $tahun; ?>">
                    </td>

                    <td class="col-auto">
                        <button type="submit" name="buttonType" value="bulanan" class="btn btn-info mb-4 float-end ms-2">Print Bulanan</button>
                    </td>

                    <td class="col-auto">
                        <button type="submit" value="tahunan" name="buttonType" class="btn btn-info mb-4 float-end ms-2">Print Semua</button>
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
                            <div class="col-6 col-sm-3 mt-2">
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
                            <div class="col-auto mt-2 d-grid">
                                <input type="text" readonly class="form-control mb-4 ms-1" value="<?php $tahun = date('Y');
                                echo $tahun; ?>">
                                <input type="hidden" name="year" class="form-control mb-4" value="<?php $tahun = date('Y');
                                echo $tahun; ?>">
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
                <p class="card-title fs-5 fw-bold mb-0">{{ $buln }}</p>
            </div>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th colspan="3">
                            <p class="fs-5">KYG</p>
                            <p class="fs-7 mb-0">Total Tiket : {{ $totalkyg }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Pengebab Gangguan
                        </th>
                        <th>
                            Jumlah
                        </th>
                        <th>
                            Persen
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($perfpsb as $perf)
                        @if ($perf->sektor == 'KYG')
                            <tr>
                                <td>
                                    {{ $perf->penyebab }}
                                </td>
                                <td>
                                    {{ $perf->count }}
                                </td>
                                <td>
                                    {{ number_format(($perf->count / $totalkyg) * 100) }}%
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td align="center" colspan="3">
                                    Data Kosong
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td align="center" colspan="3">
                                Data Kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th colspan="3">
                            <p class="fs-5">BJM</p>
                            <p class="fs-7 mb-0">Total Tiket : {{ $totalbjm }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Pengebab Gangguan
                        </th>
                        <th>
                            Jumlah
                        </th>
                        <th>
                            Persen
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($perfpsb as $perf)
                        @if ($perf->sektor == 'BJM')
                            <tr>
                                <td>
                                    {{ $perf->penyebab }}
                                </td>
                                <td>
                                    {{ $perf->count }}
                                </td>
                                <td>
                                    {{ number_format(($perf->count / $totalbjm) * 100) }}%
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td align="center" colspan="3">
                                    Data Kosong
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td align="center" colspan="3">
                                Data Kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th colspan="3">
                            <p class="fs-5">ULI</p>
                            <p class="fs-7 mb-0">Total Tiket : {{ $totaluli }}</p>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Pengebab Gangguan
                        </th>
                        <th>
                            Jumlah
                        </th>
                        <th>
                            Persen
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($perfpsb as $perf)
                        @if ($perf->sektor == 'ULI')
                            <tr>
                                <td>
                                    {{ $perf->penyebab }}
                                </td>
                                <td>
                                    {{ $perf->count }}
                                </td>
                                <td>
                                    {{ number_format(($perf->count / $totaluli) * 100) }}%
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td align="center" colspan="3">
                                    Data Kosong
                                </td>
                            </tr>
                        @endif
                    @empty
                    <tr>
                        <td align="center" colspan="3">
                            Data Kosong
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>



    </div>

@endsection
