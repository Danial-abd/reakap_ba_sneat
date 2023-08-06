@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Material')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4">
        Data Material
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-7 col-12 mt-2">
                            <form action="{{ route('search.lm') }}" method="GET" class="form-item">
                                <div class="input-group">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31"><i
                                                class="bx bx-search"></i></span>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Nama dan Kode" aria-label="Search..."
                                            aria-describedby="basic-addon-search31">
                                    </div>
                                    {{-- <input type="search" name="search" class="form-control" aria-label="Text input with dropdown button"> --}}
                            </form>
                        </div>
                    </div>
                    <div class="col mt-2 d-grid mx-auto">
                        <a href="{{route('tbh.lm')}}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    {{-- <div class="col mt-2 d-grid mx-auto">
                                <a href=" " target="_blank" class="btn btn-success">Print</a>
                            </div> --}}
                </div>

            </div>
            <dir class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>NO</th>
                                <th>Kode Material</th>
                                <th>Nama Material</th>
                                <th>Penggunaan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($material as $mm)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $mm->kd_material }}</td>
                                    <td>{{ $mm->nama_material }}</td>
                                    <td>
                                        {{ $mm->job }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('edt.mm', $mm->id) }}"><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</a>
                                                <a class="dropdown-item" href="{{ route('dlt.mm', $mm->id) }}"><i class="bx bx-trash me-1"></i>
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


{{-- <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Filter</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" name="asd">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#">Separated link</a></li>
                                    </ul> --}}
