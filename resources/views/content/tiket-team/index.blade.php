@extends('layouts/contentNavbarLayout')

@section('title', 'Rekap Pengerjaan Tiket')

@section('content')

    {{-- <div class="container"> --}}
    {{-- form print --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            <tr>
                <td class="col-md-7">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        Rekap Tiket
                    </h4>
                </td>
                @if (auth()->user()->jobdesk->jobdesk == "Master" || auth()->user()->jobdesk->jobdesk == "Admin")
                <form action="{{ route('print.tiket') }}" method="get" class="form-item" enctype="multipart/form-data">
                    <td class="col-md-2">
                        <select name="jtiket" class="form-control mb-4">
                            <option value="" disabled selected>-Pekerjaan-</option>
                            @foreach ($jenistiket as $jt)
                                <option value="{{ $jt->nama_tiket }}">{{ $jt->nama_tiket }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="col-md-2">
                        <select name="bulan" class="form-control mb-4">
                            <option value="" disabled selected>--Bulan--</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </td>
                    <td class="col-md-2 col-2">
                        <input type="text" readonly class="form-control mb-4 ms-1" value="<?php $tahun = date('Y');
                        echo $tahun; ?>">
                        <input type="hidden" name="tahun" class="form-control mb-4" value="<?php $tahun = date('Y');
                        echo $tahun; ?>">
                    </td>
                    <td>
                        <button type="submit" target="_blank" class="btn btn-info mb-4 float-end ms-2" name="cari">print</button>
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
                            <select name="bulan" class="form-control">
                                <option value="" disabled selected>--Bulan--</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        @if (auth()->user()->jobdesk->jobdesk == "Master")
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
                    @if(auth()->user()->jobdesk->jobdesk == "Teknisi")
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
                                <th>Nama Tim</th>
                                <th>Anggota</th>
                                <th>No Tiket</th>
                                <th>Nama PIC</th>
                                <th>No PIC</th>
                                <th>alamat</th>
                                <th>Pekerjaan</th>
                                <th>Ket</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($tiktim as $t)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $t->teamlist->list_tim }}</td>
                                    <td>{{ $t->teamdetail->karyawan->nama }}</td>
                                    <td>{{ $t->tiketlist->no_tiket }}</td>
                                    <td>{{ $t->tiketlist->nama_pic }}</td>
                                    <td>{{ $t->tiketlist->no_pic }}</td>
                                    <td>{{ $t->tiketlist->alamat }}</td>
                                    <td>{{ $t->tiketlist->jenistiket->nama_tiket }}</td>
                                    <td>{{ $t->tiketlist->ket }}</td>
                                    <td>{{ $t->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('edt.tiket', $t->id) }}"><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</a>
                                                <a class="dropdown-item" href="{{ route('dlt.tiket', $t->id) }}"><i class="bx bx-trash me-1"></i>
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
