@extends('layouts/contentNavbarLayout')

@section('title', 'Data Penyebab')

@section('content')

    {{-- <div class="container"> --}}
    <h4 class="fw-bold py-3 mb-4">
        Daftar Penyebab Gangguan
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col mt-2 d-grid mx-auto">
                        <a href="{{ route('pg-create') }}" class="btn btn-primary">Tambah Penyebab</a>
                    </div>
                </div>

                <dir class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>NO</th>
                                    <th>Penyebab</th>
                                    <th>Job</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($Ggnpenyebab as $index => $ggn)
                                    @if ($index != 0)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>

                                                {{ $ggn->penyebab }}

                                            </td>
                                            <td> {{$ggn->job}} </td>
                                            <td>
                                                <a href="{{ route('pg-edit', $ggn->id) }}" class="btn btn-sm btn-warning"
                                                    title="Edit Data"><span class="bx bxs-edit"></span></a>
                                                <a href="{{ route('pg-dlt', $ggn->id) }}" class="btn btn-sm btn-danger"
                                                    title="Hapus Data"><span class="bx bxs-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </dir>
            </div>
        </div>
    </div>
    </div>
    {{-- </div> --}}
@endsection
