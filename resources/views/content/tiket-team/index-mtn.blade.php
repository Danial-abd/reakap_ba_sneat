@extends('layouts/contentNavbarLayout')

@section('title', 'Rekap Pengerjaan Tiket')

@section('content')

    {{-- <div class="container"> --}}
    {{-- form print --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            <tr>
                <td class="col-md-8">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        Rekap Tiket
                    </h4>
                </td>

                @if (auth()->user()->jobdesk->jobdesk == 'Master' || auth()->user()->jobdesk->jobdesk == 'Admin')
                    <form action="{{ route('print.tiket-psb') }}" method="get" target="_blank" class="form-item"
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
                @endif
            </tr>
        </table>
    </div>
    {{-- /form print --}}

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Session::has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-12 mt-2">
                            <form action="" method="GET" class="form-item">
                                <div class="input-group">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31"><i
                                                class="bx bx-search"></i></span>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Nama dan No Tiket" aria-label="Search..."
                                            aria-describedby="basic-addon-search31">
                                    </div>
                                </div>
                        </div>
                        <div class="col mt-2 d-grid mx-auto">
                            @php
                                $bln = date('m');
                            @endphp
                            <select name="bulan" class="form-control">
                                <option value="" disabled selected>--Bulan--</option>
                                <option value="">Semua Data</option>
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
                                <option value="12" {{ $bln == 012 ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>
                        <div class="col mt-2 d-grid mx-auto">
                            <button type="submit" class="btn btn-info" name="cari">Cari</button>
                        </div>
                        </form>

                        {{-- /form pencarian --}}
                        @if (auth()->user()->jobdesk->jobdesk == 'Teknisi')
                            <div class="col mt-2 d-grid mx-auto">
                                <a href="{{ route('tbh.tiket') }}" class="btn btn-primary">Tambah Data</a>
                            </div>
                        @endif
                    </div>

                </div>
                <dir class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tim</th>
                                    <th>Sektor</th>
                                    <th>No Tiket</th>
                                    <th>Pekerjaan</th>
                                    <th>Ket Tiket</th>
                                    <th>Tanggal Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($tiktim as $t)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $t->teamlist->list_tim }}</td>
                                        <td>
                                            @foreach ($t->teamlist->sektor as $tl)
                                                {{ $tl->sektor }}
                                            @endforeach
                                        </td>
                                        <td>{{ $t->no_tiket }}</td>
                                        <td>{{ $t->pekerjaan }}</td>
                                        <td>{{ $t->ket }}</td>
                                        <td>{{ $t->updated_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </dir>
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection
