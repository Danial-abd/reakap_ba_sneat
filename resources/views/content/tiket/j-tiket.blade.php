@extends('layouts/contentNavbarLayout')

@section('title', 'Data Tiket Pekerjaan')

@section('content')

    {{-- <div class="container"> --}}
    <h4 name="judul" class="fw-bold py-3 mb-4">
        Tiket Pekerjaan
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 col-12 mt-2">
                            <form action="" method="GET" class="form-item"> 
                                <div class="input-group">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31"><i
                                                class="bx bx-search"></i></span>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Nama Tiket" aria-label="Search..."
                                            aria-describedby="basic-addon-search31">
                                    </div>
                                    {{-- <input type="search" name="search" class="form-control" aria-label="Text input with dropdown button"> --}}
                            </form>
                        </div>
                    </div>
                    <div class="col mt-2 d-grid mx-auto">
                        <a href="{{ route('tambah.jt') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                </div>

            </div>
            <dir class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Tiket</th>
                                <th>Action</th>
                            </tr>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($jenistiket as $jt)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $jt->nama_tiket }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('edt.jt', $jt->id) }}"><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</a>
                                                <a class="dropdown-item" href="{{ route('dlt.jt', $jt->id) }}"><i class="bx bx-trash me-1"></i>
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
