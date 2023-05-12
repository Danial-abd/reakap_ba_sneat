@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tiiket Pasang Baru')

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
                            <option value="01" >Januari</option>
                            <option value="02" >Februari</option>
                            <option value="03" >Maret</option>
                            <option value="04" >April</option>
                            <option value="05" >Mei</option>
                            <option value="06" >Juni</option>
                            <option value="07" >Juli</option>
                            <option value="08" >Agustus</option>
                            <option value="09" >September</option>
                            <option value="10" >Oktober</option>
                            <option value="11" >November</option>
                            <option value="12" >Desember</option>
                        </select>
                    </div>
                    <div class="col mt-2 d-grid mx-auto">
                        <button type="submit" class="btn btn-info">Cari</button>
                    </div>
                    </form>
                    @if (auth()->user()->jobdesk->jobdesk == "Admin")
                    <div class="col mt-2 d-grid mx-auto">
                        <a href="{{ route('tbh.psb') }}" class="btn btn-primary">Tambah Data</a>
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
                                <th>No Tiket</th>
                                <th>Jenis Tiket</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Tiket Open</th>
                                <th>Ket</th>
                                <th>Aksi</th>
                            </tr>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($tiketlist as $tl)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $tl->no_tiket }}</td>
                                    <td>{{ $tl->jenistiket->nama_tiket }}</td>
                                    <td>{{ $tl->nama_pic }}</td>
                                    <td>{{ $tl->alamat }}</td>
                                    <td>{{ $tl->no_pic }}</td>
                                    <td>{{ $tl->created_at }}</td>
                                    <td>{{ $tl->ket }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('edt.ggn', $tl->id) }}"><i
                                                        class="bx bx-edit-alt me-1"></i>
                                                    Edit</a>
                                                <a class="dropdown-item" href="{{ route('dlt.ggn', $tl->id) }}"><i
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
