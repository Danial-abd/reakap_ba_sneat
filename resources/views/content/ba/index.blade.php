@extends('layouts/contentNavbarLayout')

@section('title', 'Data Berita Acara')

@section('content')

    {{-- <div class="container"> --}}

    {{-- form print --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            <tr>
                <td class="col-md-8">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        Berita Acara
                    </h4>
                </td>
                @if (auth()->user()->jobdesk->jobdesk == 'Master')
                    <form action="{{ route('print.ba') }}" method="get" class="form-item" enctype="multipart/form-data">
                        <td class="col-md-1">
                            <select name="team" class="form-control mb-4">
                                <option value="" disabled selected>-Nama Tim-</option>
                                @foreach ($teamlist as $td)
                                    <option value="{{ $td->list_tim }}">{{ $td->list_tim }}</option>
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
                        <td class="col-md-1 col-2">
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
                                            placeholder="Cari Nama Tim dan No Berita Acara" aria-label="Search..."
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
                        <div class="col mt-2 d-grid mx-auto">
                            <button type="submit" class="btn btn-info" name="cari">Cari</button>
                        </div>
                        </form>
                        {{-- /form pencarian --}}

                        <div class="col mt-2 d-grid mx-auto">
                            <a href="{{ route('tbh.ba') }}" class="btn btn-primary">Tambah Data</a>
                        </div>


                        {{-- Form Download Semua File Berita Acara --}}
                        <div class="table-responsive">
                            <table class="table-borderless align-middle mt-4">
                                <form action="{{ route('merge.ba') }}" method="get" class="form-item"
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
                                            <select name="bulan" class="form-control mb-2">
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
                                                class="btn btn-info float-end mb-2 ms-2" name="cari">Download</button>
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
                                    <th>Pekerjaan</th>
                                    <th>No BA</th>
                                    <th>Nama Material</th>
                                    <th>Jumlah</th>
                                    <th>File Berita Acara</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($beritaacara as $ba)
                                    <tr class="align-baseline">
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $ba->teamlist->list_tim }}</td>
                                        <td>{{ $ba->teamdetail->jobdesk->jenistiket->nama_tiket ?? '' }}</td>
                                        <td>{{ $ba->no_ba }}</td>

                                        <td>
                                            @foreach ($ba->saldomaterial as $nm)
                                                {{ $nm->material->nama_material }} </br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($ba->saldomaterial as $nm)
                                                {{ $nm->jumlah }} {{$nm->jumlah >= 1000 ? 'm' : 'pcs'}}</br>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $ba->file_ba }}
                                            <a href="/ba/show/{{ $ba->id }}/{{ $ba->file_ba }}" target="_blank"
                                                class="float-end btn btn-sm btn-success">Lihat
                                                File</a>
                                        </td>
                                        <td>{{ $ba->updated_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('edt.ba', $ba->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item" href="{{ route('dlt.ba', $ba->id) }}"><i
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
