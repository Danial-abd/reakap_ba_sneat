@extends('layouts/contentNavbarLayout')

@section('title','Data Jobdesk')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4">
        Jobdesk
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    
                    <div class="row">
                            <div class="col-md-7 col-12 mt-2">
                                <form action="{{ route('search.jd') }}" method="GET" class="form-item">
                                <div class="input-group">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                                        <input type="text" name="search" class="form-control" placeholder="Cari Nama dan NIK" aria-label="Search..." aria-describedby="basic-addon-search31">
                                      </div>
                                    {{-- <input type="search" name="search" class="form-control" aria-label="Text input with dropdown button"> --}}
                                </form>
                                </div>
                            </div>
                            <div class="col mt-2 d-grid mx-auto">
                                <a href="{{ route('tambah.jd') }}" class="btn btn-primary">Tambah Data</a>
                            </div>
                            {{-- <div class="col mt-2 d-grid mx-auto">
                                <a href="" class="btn btn-success">Print</a>
                            </div> --}}
                    </div>
                
                </div>
                <dir class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>NO</th>
                                    <th>Kode Jobdesk</th>
                                    <th>Nama Jobdesk</th>
                                    <th>Detail Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($jobdesk as $jd)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $jd->kd_jd }}</td>
                                        <td>{{ $jd->jobdesk }}</td>
                                        <td>{{ $jd->detail_kerja }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('edt.jd', $jd->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item" href="{{ route('dlt.jd', $jd->id) }}"><i
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