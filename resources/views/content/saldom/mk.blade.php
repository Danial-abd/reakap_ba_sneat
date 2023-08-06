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
                <form action="{{ route('mk-print') }}" method="get" target="_blank" class="form-item"
                    enctype="multipart/form-data">
                    <td class="col-md-2">
                        @php
                            $bln = date('m');
                        @endphp
                        <select name="bulan" class="form-control mb-4">
                            <option value="" disabled selected>--Bulan--</option>
                            <option value="01" {{ $bln == 1 ? 'selected' : '' }}>Januari</option>
                            <option value="03" {{ $bln == 03 ? 'selected' : '' }}>Maret</option>
                            <option value="02" {{ $bln == 02 ? 'selected' : '' }}>Februari</option>
                            <option value="04" {{ $bln == 04 ? 'selected' : '' }}>April</option>
                            <option value="05" {{ $bln == 05 ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ $bln == 06 ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ $bln == 07 ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ $bln == 8 ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ $bln == 9 ? 'selected' : '' }}>September</option>
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
    @if ($reminder != null)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Reminder!!</strong> {{ $reminder }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                        </div>
                    </form>
                </div>

            </div>

            <h4 class="mt-5">Pasang Baru</h4>
            @for ($i = 0; $i < $teampsb->count(); $i++)
                <div class="card mb-3 ">
                    <div class="card-header">
                        <p class="card-title fs-5 fw-bold">{{ $teampsb[$i]->list_tim }}</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Nama Material
                                        </th>
                                        <th>
                                            Sisa
                                        </th>
                                        <th>
                                            Digunakan
                                        </th>
                                        <th>
                                            Pengembalian
                                        </th>
                                    </tr>
                                </thead>

                                @for ($q = 0; $q < $saldo->count(); $q++)
                                    @if ($saldo[$q]->id_tim == $teampsb[$i]->id)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $saldo[$q]->material->nama_material }}
                                                </td>
                                                <td>
                                                    {{ $saldo[$q]->total_jumlah }}
                                                </td>
                                                <td>
                                                    {{ $saldo[$q]->guna }}
                                                </td>
                                                <td>
                                                    {{ $pengembalian[$q]->guna ?? '0' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endif
                                @endfor
                            </table>
                        </div>
                    </div>
                </div>
            @endfor

        </div>
    </div>
@endsection
