@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tiket Pasang Baru')

@section('content')

    {{-- <div class="container"> --}}
        <div class="table-responsive">
            <table class="table-borderless align-middle">
                <tr>
                    <td class="col-md-9">
                        <h4 name="judul" class="fw-bold py-3 mb-4">
                            Tiket Pasang Baru
                        </h4>
                    </td>
                </tr>
            </table>
        </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Session::has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        
            <div class="card accordion-item mb-4">
                <h2 class="accordion-header" id="headingOne">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                        Filter
                    </button>
                </h2>

                <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample"
                    style="">
                    <div class="accordion-body">
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
                                        {{-- <input type="search" name="search" class="form-control" aria-label="Text input with dropdown button"> --}}
                                    </div>
                            </div>
                            <div class="col mt-2 d-grid mx-auto">
                            @php
                                $bln = date('m');
                            @endphp
                                <select name="bulan" class="form-control">
                                    <option value="" disabled selected>--Bulan--</option>
                                    <option value="">Semua Data</option>
                                    <option value="01" {{ $bln == 1 ? 'selected' : ""}}>Januari</option>
                                    <option value="03" {{ $bln == 03 ? 'selected' : ""}}>Maret</option>
                                    <option value="02" {{ $bln == 02 ? 'selected' : ""}}>Februari</option>
                                    <option value="04" {{ $bln == 04 ? 'selected' : ""}}>April</option>
                                    <option value="05" {{ $bln == 05 ? 'selected' : ""}}>Mei</option>
                                    <option value="06" {{ $bln == 06 ? 'selected' : ""}}>Juni</option>
                                    <option value="07" {{ $bln == 07 ? 'selected' : ""}}>Juli</option>
                                    <option value="08" {{ $bln == 8 ? 'selected' : ""}}>Agustus</option>
                                    <option value="09" {{ $bln == 9 ? 'selected' : ""}}>September</option>
                                    <option value="10" {{ $bln == 10 ? 'selected' : ""}}>Oktober</option>
                                    <option value="11" {{ $bln == 11 ? 'selected' : ""}}>November</option>
                                    <option value="12" {{ $bln == 012 ? 'selected' : ""}}>Desember</option>
                                </select>
                            </div>
                            <div class="col mt-2 d-grid mx-auto">
                                <button type="submit" class="btn btn-info" name="cari">Cari</button>
                            </div>
                            </form>
                            @if (auth()->user()->jobdesk->jobdesk == 'Admin')
                                <div class="col mt-2 d-grid mx-auto">
                                    <a href="{{ route('tbh.ggn') }}" class="btn btn-primary">Tambah Data</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <h5>Input Baru</h5>
                    </div>
                    

                </div>
                <dir class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Status Tiket</th>
                                    <th>Nama Tim</th>
                                    <th>No Tiket</th>
                                    <th>No Inet</th>
                                    <th>Nama PIC</th>
                                    <th>Ket</th>
                                    <th>Tanggal Upload</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($tiktim as $t)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $t->status }}</td>
                                        <td>{{ $t->teamlist->list_tim }}</td>
                                        <td>{{ $t->no_tiket }}</td>
                                        <td>{{ $t->no_inet }}</td>
                                        <td>{{ $t->nama_pic }}</td>
                                        <td>{{ $t->ket }}</td>
                                        <td>{{ $t->created_at }}</td>
                                        <td>
                                            {{-- <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('edt.ggn', $t->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item" href="{{ route('dlt.ggn', $t->id) }}"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Delete</a>
                                                </div> --}}

                                                <a href="{{route('edt.detail', $t->id)}}" class="btn btn-sm btn-info"><span class="bx bx-info-circle"></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td class="align-middle" colspan="12" align="center">
                                        Data Kosong
                                    </td>
                                </tr>
                                @endforelse
                                </tbody>
                        </table>
                    </div>
                </dir>
            </div>
            <hr class="container-m-nx border-light mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <h5>Revisi</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Status Tiket</th>
                                    <th>Nama Tim</th>
                                    <th>No Tiket</th>
                                    <th>No Inet</th>
                                    <th>Nama PIC</th>
                                    <th>Ket</th>
                                    <th>Tanggal Upload</th>
                                    <th>Status Perbaikan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($tikrev as $rev)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $rev->status }}</td>
                                        <td>{{ $rev->teamlist->list_tim }}</td>
                                        <td>{{ $rev->no_tiket }}</td>
                                        <td>{{ $rev->no_inet }}</td>
                                        <td>{{ $rev->nama_pic }}</td>
                                        <td>{{ $rev->ketrev }} <br>|| Menunggu Teknisi Memperbaiki Data</td>
                                        <td>{{ $rev->created_at }}</td>
                                        <td>
                                                {{-- <a href="{{route('edt.detail', $rev->id)}}" class="btn btn-sm btn-info"><span class="bx bx-info-circle"></span></a> --}}
                                            Menunggu perbaikan laporan dari teknisi
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td class="align-middle" colspan="12" align="center">
                                        Data Kosong
                                    </td>
                                </tr>
                                @endforelse
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="container-m-nx border-light mt-5">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <h5>Aproved</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Status Tiket</th>
                                    <th>Nama Tim</th>
                                    <th>No Tiket</th>
                                    <th>No Inet</th>
                                    <th>Nama PIC</th>
                                    <th>Ket</th>
                                    <th>Tanggal Upload</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($tikacc as $acc)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $acc->status }}</td>
                                        <td>{{ $acc->teamlist->list_tim }}</td>
                                        <td>{{ $acc->no_tiket }}</td>
                                        <td>{{ $acc->no_inet }}</td>
                                        <td>{{ $acc->nama_pic }}</td>
                                        <td>{{ $acc->ket }}</td>
                                        <td>{{ $acc->created_at }}</td>
                                        <td>
                                                <a href="{{route('edt.detail', $acc->id)}}" class="btn btn-sm btn-info" title="Detail"><span class="bx bx-info-circle"></span></a>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td class="align-middle" colspan="12" align="center">
                                        Data Kosong
                                    </td>
                                </tr>
                                @endforelse
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- </div> --}}
@endsection
