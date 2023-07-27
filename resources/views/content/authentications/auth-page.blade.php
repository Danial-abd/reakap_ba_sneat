@extends('layouts/contentNavbarLayout')

@section('title', 'Data User')

@section('content')

    {{-- form print --}}
    <div class="table-responsive">
        <table class="table-borderless align-middle">
            <tr>
                <td class="col-md-7">
                    <h4 name="judul" class="fw-bold py-3 mb-4">
                        Data User
                    </h4>
                </td>
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
                            <button type="submit" class="btn btn-info" name="cari">Cari</button>
                        </div>
                        </form>

    {{-- /form pencarian --}}

                        <div class="col mt-2 d-grid mx-auto">
                            <a href="{{ route('register') }}" class="btn btn-primary">Registrasi Akun</a>
                        </div>

                    </div>
                </div>

                <dir class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Tanggal Buat</th>
                                    <th>Tanggal Edit</th>
                                    <th>Role</th>
                                    <th>Nama Tim</th>
                                    <th>Aksi</th>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($user as $usr)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $usr->karyawan->nik }}</td>
                                        <td>{{ $usr->karyawan->nama }}</td>
                                        <td>{{ $usr->email }}</td>
                                        <td>{{ $usr->created_at }}</td>
                                        <td>{{ $usr->updated_at }}</td>
                                        <td>{{ $usr->jobdesk->jobdesk }} {{ $usr->jobdesk->jenistiket->nama_tiket ?? ""}}</td>
                                        <td>{{ $usr->teamdetail->teamlist->list_tim ?? ''}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route("edt.usr", $usr->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item" href="{{ route("dlt.usr", $usr->id) }}"><i
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
