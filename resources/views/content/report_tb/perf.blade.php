@extends('layouts/contentNavbarLayout')

@section('title', 'Data Total Material')

@section('content')

    {{-- <div class="container"> --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            <tr>
                <td class="col-md-10">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        Jumlah Pasang Baru perbulan
                    </h4>
                </td>
                <form action="{{ route("print-pf") }}" target="_blank" method="get"  class="form-item" enctype="multipart/form-data">
                    <td></td>
                    <td class="col-md-2 col-2">
                        <input type="number" name="year" min="1900" class="form-control mb-4" max="2099"
                            step="1" value="<?php $tahun = date('Y');
                            echo $tahun; ?>" />
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
            @forelse ($blan as $bln)
                @php
                    if ($bln->month == 1) {
                        $carbon = 'Januari';
                    } elseif ($bln->month == 2) {
                        $carbon = 'Februari';
                    } elseif ($bln->month == 3) {
                        $carbon = 'Maret';
                    } elseif ($bln->month == 4) {
                        $carbon = 'April';
                    } elseif ($bln->month == 5) {
                        $carbon = 'Mei';
                    } elseif ($bln->month == 6) {
                        $carbon = 'Juni';
                    } elseif ($bln->month == 7) {
                        $carbon = 'Juli';
                    } elseif ($bln->month == 8) {
                        $carbon = 'Agustus';
                    } elseif ($bln->month == 9) {
                        $carbon = 'September';
                    } elseif ($bln->month == 10) {
                        $carbon = 'Oktober';
                    } elseif ($bln->month == 11) {
                        $carbon = 'November';
                    } elseif ($bln->month == 12) {
                        $carbon = 'Desember';
                    }
                @endphp
                <div class="card mb-4">
                    <div class="card-header">
                        <p class="fs-4 fw-bold">{{ $carbon }}</p>
                        @foreach ($totalpsb as $total)
                            @if ($total->month == $bln->month)
                                <p class="fs-6">Total Pemasangan = {{ $total->count }} </p>
                            @endif
                        @endforeach
                    </div>
                    <div class="card-body">
                        <div class="table-respomsive">
                            <table class="table">
                                <thead class=" table-light">
                                    <tr>
                                        <th>
                                            Sektor
                                        </th>
                                        <th>
                                            Jumlah
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($perfpsb as $perf)
                                        @if ($bln->month == $perf->month)
                                            <tr>
                                                <td>
                                                    {{ $perf->sektor }}
                                                </td>
                                                <td>
                                                    {{ $perf->count }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
            <div class="card mb-4">
                <div class="card-body">
                    <p>Data Kosong</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
@endsection
