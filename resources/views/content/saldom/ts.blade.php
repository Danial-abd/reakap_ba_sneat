@extends('layouts/contentNavbarLayout')

@section('title', 'Data Total Material')

@section('content')

    {{-- <div class="container"> --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            <tr>
                <td class="col-md-8">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        Data Total Material
                    </h4>
                </td>
                
                <form action="{{ route('tm-print') }}" method="get" target="_blank" class="form-item"
                enctype="multipart/form-data">
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


        @foreach ($jtiket as $jt)
            <div class="card mb-4">
                <div class="body">
                    <div class="card-header fs-5 fw-bold">
                        {{ $jt->nama_tiket }}
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            @if ($jt->id == 1)
                                <caption class="ms-4 fw-bold">Total Tiket yang dikerjakan : {{ $tiketggn }}</caption>
                            @endif
                            @if ($jt->id == 2)
                                <caption class="ms-4 fw-bold">Total Tiket yang dikerjakan : {{ $tiketpsb }}</caption>
                            @endif
                            @if ($jt->id == 3)
                                <caption class="ms-4 fw-bold">Total Tiket yang dikerjakan : {{ $tiketmtn }}</caption>
                            @endif

                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Nama Material
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Terpakai
                                    </th>
                                    <th>
                                        Sisa
                                    </th>
                                </tr>
                            </thead>
                            @php
                                $i = 1;
                            @endphp
                            <tbody>
                                @if ($jt->id == 2)
                                    @forelse ($saldopsb as $sp)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $sp->material->nama_material }}</td>
                                            <td>{{ $sp->jumlah }}</td>
                                            <td>{{ $sp->guna }}</td>
                                            <td>{{ $sp->total_jumlah }}</td>
                                        </tr>
                                    @empty
                                        <tr >
                                            <td colspan="5">Data Kosong</td>
                                        </tr>
                                    @endforelse
                                @endif
                                @if ($jt->id == 1)
                                    @forelse ($saldoggn as $sg)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $sg->material->nama_material }}</td>
                                            <td>{{ $sg->jumlah }}</td>
                                            <td>{{ $sg->guna }}</td>
                                            <td>{{ $sg->total_jumlah }}</td>
                                        </tr>
                                    @empty
                                        <tr >
                                            <td colspan="5">Data Kosong</td>
                                        </tr>
                                    @endforelse
                                @endif
                                @if ($jt->id == 3)
                                    @forelse ($saldomtn as $sm)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $sm->material->nama_material }}</td>
                                            <td>{{ $sm->jumlah }}</td>
                                            <td>{{ $sm->guna }}</td>
                                            <td>{{ $sm->total_jumlah }}</td>
                                        </tr>
                                    @empty
                                        <tr >
                                            <td colspan="5">Data Kosong</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
            </div>
        @endforeach



    </div>
    </div>

@endsection
