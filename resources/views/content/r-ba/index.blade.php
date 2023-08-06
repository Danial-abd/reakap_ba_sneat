@extends('layouts/contentNavbarLayout')

@section('title', 'Data Rekap Berita Acara')

@section('content')

    {{-- form print --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            <tr>
                <td class="col-md-7">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        Rekap Berita Acara
                    </h4>
                </td>
                @if (auth()->user()->jobdesk->jobdesk == 'Master' || auth()->user()->jobdesk->jobdesk == 'Admin')
                    @if ($rba == 'psb')
                    <form action="{{ route('print.rba-psb') }}" target="_blank"  method="get" class="form-item" enctype="multipart/form-data">
                    @endif
                    @if ($rba == 'ggn')
                    <form action="{{ route('print.rba-ggn') }}" method="get" target="_blank" class="form-item" enctype="multipart/form-data">
                    @endif
                    @if ($rba == 'mtn')
                    <form action="{{ route('print.rba-mtn') }}" method="get" target="_blank" class="form-item" enctype="multipart/form-data">
                    @endif
                    
                        <td class="col-md-2">
                        </td>
                        <td class="col-md-2">
                            @php
                                $bln = date('m');
                            @endphp
                            <select name="bulan" class="form-control mb-4">
                                <option value="" disabled selected>--Bulan--</option>
                                <option value="01" {{ $bln == 1 ? 'selected' : '' }}>Januari</option>
                                <option value="02"{{ $bln == 2 ? 'selected' : '' }}>Februari</option>
                                <option value="03" {{ $bln == 3 ? 'selected' : '' }}>Maret</option>
                                <option value="04" {{ $bln == 4 ? 'selected' : '' }}>April</option>
                                <option value="05" {{ $bln == 5 ? 'selected' : '' }}>Mei</option>
                                <option value="06" {{ $bln == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="07" {{ $bln == 7 ? 'selected' : '' }}>Juli</option>
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
                        <td>
                            <button type="submit" target="_blank" class="btn btn-info mb-4 float-end ms-2"
                                name="cari">print</button>
                        </td>
                    </form>
                @endif
            </tr>
        </table>
    </div>
    {{-- /form print --}}

    {{-- form pencarian --}}
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
                                <option value="01" {{ $bln == 1 ? 'selected' : '' }}>Januari</option>
                                <option value="02"{{ $bln == 2 ? 'selected' : '' }}>Februari</option>
                                <option value="03" {{ $bln == 3 ? 'selected' : '' }}>Maret</option>
                                <option value="04" {{ $bln == 4 ? 'selected' : '' }}>April</option>
                                <option value="05" {{ $bln == 5 ? 'selected' : '' }}>Mei</option>
                                <option value="06" {{ $bln == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="07" {{ $bln == 7 ? 'selected' : '' }}>Juli</option>
                                <option value="08" {{ $bln == 8 ? 'selected' : '' }}>Agustus</option>
                                <option value="09" {{ $bln == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $bln == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ $bln == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $bln == 12 ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>
                        @if (auth()->user()->jobdesk->jobdesk == 'Master')
                            <div class="col mt-2 d-grid mx-auto">
                                <select name="jtiket" class="form-control">
                                    <option value="" disabled selected>-Pekerjaan-</option>
                                    @foreach ($jenistiket as $jt)
                                        <option value="{{ $jt->nama_tiket }}">{{ $jt->nama_tiket }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col mt-2 d-grid mx-auto">
                            <button type="submit" class="btn btn-info" name="cari">Cari</button>
                        </div>
                        </form>

                        {{-- /form pencarian --}}
                        @if (auth()->user()->jobdesk->jobdesk == 'Teknisi')
                            <div class="col mt-2 d-grid mx-auto">
                                <a href="{{ route('tbh.rba') }}" class="btn btn-primary">Tambah Data</a>
                            </div>
                        @endif

                        {{-- Form Download Semua File Berita Acara --}}
                        <div class="table-responsive">
                            <table class="table-borderless align-middle mt-4">
                                <form action="{{ route('merge.rba') }}" method="get" class="form-item"
                                    enctype="multipart/form-data">
                                    <tr>
                                        <td class="col-md-5">
                                        </td>
                                        <td class="col-auto">
                                            <p class="fs-8 mb-2"> Download Semua File Berita Acara</p>
                                        </td>
                                        @if (auth()->user()->jobdesk->jobdesk == 'Master')
                                            <td class="col-md-1">
                                                <select name="team" class="form-control mb-2">
                                                    <option value="" disabled selected>-Nama Tim-</option>
                                                    @foreach ($teamlist as $td)
                                                        <option value="{{ $td->list_tim }}">{{ $td->list_tim }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endif
                                        <td class="col-auto">

                                            @php
                                                $bln = date('m');
                                            @endphp
                                            <select name="bulan" class="form-control">
                                                <option value="" disabled selected>--Bulan--</option>
                                                <option value="01" {{ $bln == 1 ? 'selected' : '' }}>Januari</option>
                                                <option value="02"{{ $bln == 2 ? 'selected' : '' }}>Februari</option>
                                                <option value="03" {{ $bln == 3 ? 'selected' : '' }}>Maret</option>
                                                <option value="04" {{ $bln == 4 ? 'selected' : '' }}>April</option>
                                                <option value="05" {{ $bln == 5 ? 'selected' : '' }}>Mei</option>
                                                <option value="06" {{ $bln == 6 ? 'selected' : '' }}>Juni</option>
                                                <option value="07" {{ $bln == 7 ? 'selected' : '' }}>Juli</option>
                                                <option value="08" {{ $bln == 8 ? 'selected' : '' }}>Agustus</option>
                                                <option value="09" {{ $bln == 9 ? 'selected' : '' }}>September
                                                </option>
                                                <option value="10" {{ $bln == 10 ? 'selected' : '' }}>Oktober</option>
                                                <option value="11" {{ $bln == 11 ? 'selected' : '' }}>November
                                                </option>
                                                <option value="12" {{ $bln == 12 ? 'selected' : '' }}>Desember
                                                </option>
                                            </select>
                                        </td>
                                        <td class="col-md-1">
                                            <input type="text" readonly class="form-control ms-1 mb-2"
                                                value="<?php $tahun = date('Y');
                                                echo $tahun; ?>">
                                            <input type="hidden" name="tahun" class="form-control"
                                                value="<?php $tahun = date('Y');
                                                echo $tahun; ?>">
                                        </td>
                                        <td>
                                            <button type="submit" target="_blank"
                                                class="btn btn-info float-end mb-2 ms-2" target="_blank"
                                                name="cari">Download</button>
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- /Form Download Semua File Berita Acara --}}
                <dir class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tim</th>
                                    <th>No BA</th>
                                    <th>No Tiket</th>
                                    <th>Pekerjaan</th>
                                    <th>File Berita Acara</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($rekap as $rk)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $rk->teamlist->list_tim }}</td>
                                        <td>{{ $rk->beritaacara->no_ba }}</td>
                                        <td>{{ $rk->tikettim->no_tiket }}</td>
                                        <td>{{ $rk->tikettim->jenistiket->nama_tiket }}</td>
                                        <td>
                                            {{ $rk->beritaacara->file_ba }}
                                            <a href="/rba/show/{{ $rk->beritaacara->id }}/{{ $rk->beritaacara->file_ba }}"
                                                target="_blank" class="float-end btn btn-sm btn-success">Lihat File</a>
                                        </td>
                                        <td>{{ $rk->created_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('edt.rba', $rk->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item" href="{{ route('dlt.rba', $rk->id) }}"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Delete</a>
                                                </div>
                                            </div>
                                        </td>
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
